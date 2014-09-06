<?php

namespace Neoxygen\NeoConnect\Commit;

use Neoxygen\NeoConnect\Commit\CommitStrategyInterface,
    Neoxygen\NeoConnect\Query\Queue;

class CommitManager
{
    protected $registeredStrategies = array();

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
        return true;
    }
}
