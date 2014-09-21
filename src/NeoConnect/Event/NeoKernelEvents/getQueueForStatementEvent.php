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
    NeoConnect\Statement\Statement,
    NeoConnect\Queue\Queue;

class getQueueForStatementEvent extends Event
{
    protected $queue;

    protected $connection;

    protected $statement;

    public function __construct(Statement $statement, Connection $connection)
    {
        $this->statement = $statement;
        $this->connection = $connection;
    }

    public function getStatement()
    {
        return $this->statement;
    }

    public function setStatement(Statement $statement)
    {
        $this->statement = $statement;
    }

    public function hasStatement()
    {
        return null !== $this->statement;
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
}
