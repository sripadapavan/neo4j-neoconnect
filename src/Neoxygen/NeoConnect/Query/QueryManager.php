<?php

namespace Neoxygen\NeoConnect\Query;

use Neoxygen\NeoConnect\Connection\ConnectionManager,
    Neoxygen\NeoConnect\Commit\CommitManager,
    Neoxygen\NeoConnect\Query\Statement,
    Neoxygen\NeoConnect\Query\Queue;

class QueryManager
{
    protected $connectionManager;
    protected $commitManager;
    protected $queues = array();

    public function __construct(ConnectionManager $connectionManager, CommitManager $commitManager)
    {
        $this->connectionManager = $connectionManager;
        $this->commitManager = $commitManager;
    }

    public function getQueues()
    {
        return $this->queues;
    }

    public function getConnectionManager()
    {
        return $this->connectionManager;
    }

    public function createQueue($connectionAlias)
    {
        if (!$this->connectionManager->hasConnection($connectionAlias)) {
            throw new \InvalidArgumentException(sprintf('Can not create queue, connection "%s" does not exist', $connectionAlias));
        }

        $this->queues[$connectionAlias] = array();
    }

    public function getQueue($connectionAlias)
    {
        if (!array_key_exists($connectionAlias, $this->queues)) {
            throw new \InvalidArgumentException(sprintf('The queue for connection "%s" does not exist', $connectionAlias));
        }

        return $this->queues[$connectionAlias];
    }

    public function createQuery($query, $parameters = null, $connectionAlias = null, $flushTrigger = null)
    {
        $statement = new Statement();
        $statement->setQuery($query);
        if ($parameters) {
            $statement->setParameters($parameters);
        }

        $this->addStatementToQueue($statement, $connectionAlias);

        if (null === $connectionAlias) {
            $connectionAlias = $this->connectionManager->getDefaultConnectionAlias();
        }

        $this->commitManager->handleQueue($this->getQueue($connectionAlias));

        return true;
    }

    public function addStatementToQueue(Statement $statement, $connectionAlias)
    {
        if (null === $connectionAlias) {
            $defaultAlias = $this->connectionManager->getDefaultConnectionAlias();
            if (!array_key_exists($defaultAlias, $this->queues)) {
                $queue = new Queue($defaultAlias);
                $queue->addStatement($statement);
                $this->queues[$defaultAlias] = $queue;

                return true;
            }
        } else {
            if (!array_key_exists($connectionAlias, $this->queues)) {
                if (!$this->connectionManager->hasConnection($connectionAlias)) {
                    throw new \InvalidArgumentException(sprintf('The connection %s does not exist', $connectionAlias));
                }
                $queue = new Queue($connectionAlias);
                $queue->addStatement($statement);
                $this->queues[$connectionAlias] = $queue;

                return true;
            } else {
                $queue = $this->queues[$connectionAlias];
                $queue->addStatement($statement);

                return true;
            }
        }

        throw new \InvalidArgumentException('Unable to add the query to the queue, unknown reason.');
    }

    public function getCommitManager()
    {
        return $this->commitManager;
    }
}
