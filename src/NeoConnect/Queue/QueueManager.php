<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace NeoConnect\Queue;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use NeoConnect\Connection\Connection,
    NeoConnect\Statement\Statement,
    NeoConnect\Queue\Queue;

class QueueManager implements EventSubscriberInterface
{
    const NO_QUEUE = 0;

    private $queues;

    public function __construct()
    {
        $this->queues = array();
    }

    public function getQueues()
    {
        return $this->queues;
    }

    public static function getSubscribedEvents()
    {
        return array(

        );
    }

    public function hasQueue(Connection $connection)
    {
        return array_key_exists($connection->getAlias(), $this->queues);
    }

    public function createQueue(Connection $connection)
    {
        if (!$this->hasQueue($connection)) {
            $queue = new Queue($connection->getAlias());
            $this->queues[$connection->getAlias()] = $queue;
        }

        return $this->getQueue($connection);
    }

    public function getQueue(Connection $connection)
    {
        if (!$this->hasQueue($connection)) {
            throw new \InvalidArgumentException(sprintf('The queue for connection "%s" does not exist', $connection->getAlias()));
        }
        return $this->queues[$connection->getAlias()];
    }

    public function getQueueState(Connection $connection)
    {
        if (!$this->hasQueue($connection)) {
            return self::NO_QUEUE;
        }

        return $this->getQueue($connection)->getState();
    }

    public function getQueueForAlias($connectionAlias)
    {
        if (!array_key_exists($connectionAlias, $this->queues)) {
            return null;
        }

        return $this->queues[$connectionAlias];
    }
}
