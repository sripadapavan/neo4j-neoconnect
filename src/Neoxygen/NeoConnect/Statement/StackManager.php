<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace Neoxygen\NeoConnect\Statement;

use Neoxygen\NeoConnect\Statement\StatementStack,
    Neoxygen\NeoConnect\Statement\Statement;

class StackManager
{
    protected $stack;

    public function __construct()
    {
        $this->stack = new StatementStack();
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

    public function createStatement($statement, array $parameters = array())
    {
        $statement = new Statement($statement, $parameters);
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
