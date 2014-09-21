<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace NeoConnect\Transaction;

use NeoConnect\Connection\Connection,
    NeoConnect\Queue\Queue,
    NeoConnect\Request\Request;

class Transaction
{
    private $connection;

    private $queue;

    public function __construct(Connection $connection, Queue $queue)
    {
        $this->connection = $connection;
        $this->queue = $queue;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function getQueue()
    {
        return $this->queue;
    }

    public function createRequest()
    {
        $request = new Request();
        $request->setMethod('POST');
        $request->setUrl($this->connection->getTransactionEndpoint());
        $request->setBody($this->queue->prepareForFlush());
    }
}
