<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace Neoxygen\NeoConnect\Flusher;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Neoxygen\NeoConnect\Event\QueueShouldNotBeFlushedEvent,
    Neoxygen\NeoConnect\Event\QueueShouldBeFlushedEvent,
    Neoxygen\NeoConnect\Connection\ConnectionManager,
    Neoxygen\NeoConnect\Query\QueryManager;

class Flusher implements EventSubscriberInterface
{
    protected $connectionManager;
    protected $queryManager;

    public function __construct(ConnectionManager $connectionManager, QueryManager $queryManager)
    {
        $this->connectionManager = $connectionManager;
        $this->queryManager = $queryManager;
    }

    public static function getSubscribedEvents()
    {
        return array(
            'queue.should_not_be_flushed' => array(
                array('onQueueShouldNotBeFlushed')
            ),
            'queue.should_be_flushed' => array(
                array('onQueueShouldBeFlushed')
            )
        );
    }

    public function onQueueShouldNotBeFlushed(QueueShouldNotBeFlushedEvent $event)
    {
        //var_dump($event);
    }

    public function onQueueShouldBeFlushed(QueueShouldBeFlushedEvent $event)
    {
        $queue = $event->getQueue();
        var_dump($queue);
    }
}
