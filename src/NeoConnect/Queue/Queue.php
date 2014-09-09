<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace NeoConnect\Queue;

use NeoConnect\Statement\Statement;

class Queue
{
    const EMPTY_STATE = 0;

    const NOT_EMPTY_STATE = 1;

    private $connectionAlias;

    private $statements;

    public function __construct($connectionAlias)
    {
        $this->statements = array();
        $this->connectionAlias = $connectionAlias;
    }

    public function getConnectionAlias()
    {
        return $this->connectionAlias;
    }

    public function getStatements()
    {
        return $this->statements;
    }

    public function addStatement(Statement $statement)
    {
        $this->statements[] = $statement;
    }

    public function isEmpty()
    {
        return 0 === count($this->statements);
    }

    public function getState()
    {
        if ($this->isEmpty()) {

            return self::EMPTY_STATE;
        }

        return self::NOT_EMPTY_STATE;
    }

    public function getCount()
    {
        return count($this->statements);
    }
}
