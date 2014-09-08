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
    NeoConnect\Connection\ConnectionManager;

/**
 * This class performs the complete event-based journey of the query.
 * It dispatches all the Events to perform query handling.
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

    }

    public function getConnection($connectionAlias = null)
    {
        return $this->connectionManager->getConnection($connectionAlias);
    }
}