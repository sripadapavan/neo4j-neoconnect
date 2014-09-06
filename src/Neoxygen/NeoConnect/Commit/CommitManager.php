<?php

namespace Neoxygen\NeoConnect\Commit;

use Neoxygen\NeoConnect\Commit\CommitStrategyInterface,
    Neoxygen\NeoConnect\Connection\ConnectionManager,
    Neoxygen\NeoConnect\Query\Queue,
    Neoxygen\NeoConnect\Connection\Connection,
    Neoxygen\NeoConnect\NeoConnectEvents,
    Neoxygen\NeoConnect\Event\QueueShouldNotBeFlushedEvent,
    Neoxygen\NeoConnect\Event\QueueShouldBeFlushedEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CommitManager
{
    protected $registeredStrategies = array();
    protected $loadedStrategies = array();
    protected $connectionManager;
    protected $eventDispatcher;

    public function __construct(ConnectionManager $connectionManager, EventDispatcherInterface $eventDispatcher)
    {
        $this->connectionManager = $connectionManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function registerCommitStrategy($strategyAlias, $strategyClass)
    {
        if (!class_exists($strategyClass)) {
            throw new \InvalidArgumentException(sprintf('The strategy class "%s" does not exist', $strategyClass));
        }
        $this->registeredStrategies[$strategyAlias] = $strategyClass;

        return true;
    }

    public function handleQueue(Queue $queue)
    {
        $connection = $this->getConnectionForQueue($queue);
        $strategy = $this->getStrategyForConnection($connection);
        if ($strategy->shouldBeFlushed($queue)) {
            $this->dispatchFlush($queue);
        }
        $this->dispatchNoFlush($queue);

        return true;

    }

    public function hasConnectionManager()
    {
        return null !== $this->connectionManager;
    }

    public function getStrategyForConnection(Connection $connection)
    {
        $strategyAlias = $connection->getCommitStrategy();

        if (!array_key_exists($strategyAlias, $this->registeredStrategies)) {
            throw new \InvalidArgumentException(sprintf('The commit strategy "%s" has not been configured', $strategyAlias));
        }

        if (!array_key_exists($strategyAlias, $this->loadedStrategies)) {
            $this->loadedStrategies[$strategyAlias] = new $this->registeredStrategies[$strategyAlias()];

            return $this->loadedStrategies[$strategyAlias];
        } else {
            return $this->loadedStrategies[$strategyAlias];
        }
    }

    public function getConnectionForQueue(Queue $queue)
    {
        return $this->connectionManager->getConnection($queue->getConnectionAlias());
    }

    public function dispatchNoFlush(Queue $queue)
    {
        $event = new QueueShouldNotBeFlushedEvent($queue);
        $this->eventDispatcher->dispatch(NeoConnectEvents::QUEUE_SHOULD_NOT_BE_FLUSHED_EVENT, $event);
    }

    public function dispatchFlush(Queue $queue)
    {
        $event = new QueueShouldBeFlushedEvent($queue);
        $this->eventDispatcher->dispatch(NeoConnectEvents::QUEUE_SHOULD_BE_FLUSHED_EVENT, $event);
    }
}
