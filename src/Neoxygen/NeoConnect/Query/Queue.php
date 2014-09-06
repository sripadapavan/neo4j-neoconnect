<?php

namespace Neoxygen\NeoConnect\Query;

class Queue
{
    const EMPTY_STATE_CODE = 0;

    const NON_EMPTY_STATE_CODE = 1;

    protected $connectionAlias;

    protected $statements = array();

    public function __construct($connAlias)
    {
        $this->connectionAlias = $connAlias;
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

    public function getStatementsCount()
    {
        return count($this->statements);
    }

    public function isEmpty()
    {
        return empty($this->statements);
    }

    public function getState()
    {
        if ($this->isEmpty()) {
            return self::EMPTY_STATE_CODE;
        }

        return self::NON_EMPTY_STATE_CODE;
    }
}
