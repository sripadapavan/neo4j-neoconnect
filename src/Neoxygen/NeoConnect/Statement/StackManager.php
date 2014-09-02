<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace Neoxygen\NeoConnect\Statement;

use Neoxygen\NeoConnect\NeoConnectEvents;
use Neoxygen\NeoConnect\Statement\StatementStack,
    Neoxygen\NeoConnect\Statement\Statement,
    Neoxygen\NeoConnect\EventDispatcher\EventDispatcher,
    Neoxygen\NeoConnect\Event\PreQueryAddedToStackEvent;

class StackManager
{
    protected $stack;
    protected $dispatcher;

    public function __construct(EventDispatcher $dispatcher)
    {
        $this->stack = new StatementStack();
        $this->dispatcher = $dispatcher;
    }

    public function getStack()
    {
        return $this->stack;
    }

    public function getStatements()
    {
        return $this->stack->getStatements();
    }

    public function addStatement(Statement $statement)
    {
        $this->stack->addStatement($statement);

        return $this;
    }

    public function createStatement($statement, array $parameters = array(), $flushTrigger = false)
    {
        $statement = new Statement($statement, $parameters);
        if ($flushTrigger) {
            $statement->setFlushTrigger();
        }

        $preAddEvent = new PreQueryAddedToStackEvent($statement);
        $this->dispatcher->dispatch(NeoConnectEvents::PRE_QUERY_ADD_TO_STACK, $preAddEvent);

        $this->addStatement($statement);

        return $this;
    }

    public function prepareStatementsForFlush()
    {
        $statements = array('statements' => array());
        foreach ($this->getStatements() as $statement) {
            $statements['statements'][] = $statement->prepare();
        }

        return $statements;
    }
}
