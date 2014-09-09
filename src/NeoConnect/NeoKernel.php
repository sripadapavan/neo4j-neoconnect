<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace NeoConnect;

use Symfony\Component\EventDispatcher\EventDispatcher;
use NeoConnect\NeoEvents,
    NeoConnect\Event\NeoKernelEvents\getStatementFromQueryEvent,
    NeoConnect\Event\NeoKernelEvents\getQueueForStatementEvent,
    NeoConnect\Event\NeoKernelEvents\applyStrategyForQueueEvent,
    NeoConnect\Connection\ConnectionManager,
    NeoConnect\Exception\NeoKernelException;

/**
 * This class performs the complete event-based journey of the query.
 * It dispatches all the Events to perform query handling until
 * it reaches the state of flush decision.
 *
 * If flush is ordered, a new event will trigger the transaction manager.
 * A transaction will be opened and will send all the statements of the queue.
 * The results are then returned back to the user.
 *
 * If the flush is not ordered, the Queue of statements is returned back.
 *
 *
 * @author Christophe Willemsen <willemsen.christophe@gmail.com>
 */
class NeoKernel
{
    private $connectionManager;

    private $eventDispatcher;

    public function __construct(ConnectionManager $connectionManager, EventDispatcher $eventDispatcher)
    {
        $this->connectionManager = $connectionManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function handleQuery($query, array $parameters = array(), $connectionAlias = null, array $resultDataContents = array())
    {
        $connection = $this->getConnection($connectionAlias);

        $event = new getStatementFromQueryEvent($query, $parameters, $connection);
        $this->eventDispatcher->dispatch(NeoEvents::NEO_KERNEL_STATEMENT, $event);

        if (!$event->hasStatement()) {
            throw new NeoKernelException(sprintf('The query "%s" could not be converted into a statement', $query));
        }

        $queueEvent = new getQueueForStatementEvent($event->getStatement(), $connection);
        $this->eventDispatcher->dispatch(NeoEvents::NEO_KERNEL_QUEUE, $queueEvent);

        if (!$queueEvent->hasQueue()) {
            throw new NeoKernelException(
                sprintf(
                    'An error occured while attempting add a statement to the "%s" queue', $connection->getAlias()));
        }

        $strategyEvent = new applyStrategyForQueueEvent($queueEvent->getQueue(), $connection);
        $this->eventDispatcher->dispatch(NeoEvents::NEO_KERNEL_FLUSH_STRATEGY, $strategyEvent);

        if ($strategyEvent->isFlushOrdered()) {
            // Go to transaction
        }

        return $strategyEvent->getQueue();

    }

    public function getConnection($connectionAlias = null)
    {
        return $this->connectionManager->getConnection($connectionAlias);
    }
}
