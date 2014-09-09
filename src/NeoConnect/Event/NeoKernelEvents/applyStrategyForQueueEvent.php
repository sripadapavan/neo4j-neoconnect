<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace NeoConnect\Event\NeoKernelEvents;

use Symfony\Component\EventDispatcher\Event;
use NeoConnect\Connection\Connection,
    NeoConnect\Queue\Queue;

class applyStrategyForQueueEvent extends Event
{

    const SHOULD_BE_FLUSHED = true;

    const SHOULD_NOT_BE_FLUSHED = false;

    protected $queue;

    protected $connection;

    protected $flushDecision;

    public function __construct(Queue $queue, Connection $connection)
    {
        $this->queue = $queue;

        $this->connection = $connection;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function setConnection(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function setQueue(Queue $queue)
    {
        $this->queue = $queue;
    }

    public function getQueue()
    {
        return $this->queue;
    }

    public function hasQueue()
    {
        return null !== $this->queue;
    }

    public function setFlushDecision($decision)
    {
        $this->flushDecision = (bool) $decision;
    }

    public function isFlushOrdered()
    {
        if (null === $this->flushDecision) {
            throw new \InvalidArgumentException('There was an error while processing the flush strategy');
        }

        if ($this->flushDecision) {
            return self::SHOULD_BE_FLUSHED;
        }

        return self::SHOULD_NOT_BE_FLUSHED;
    }
}
