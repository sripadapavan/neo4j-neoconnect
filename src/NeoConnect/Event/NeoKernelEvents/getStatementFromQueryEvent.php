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
    NeoConnect\Statement\Statement;

class getStatementFromQueryEvent extends Event
{
    protected $query;

    protected $parameters;

    protected $connection;

    protected $statement;

    public function __construct($query, $parameters, Connection $connection)
    {
        $this->query = $query;
        $this->parameters = $parameters;
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function setQuery($query)
    {
        $this->query = (string) $query;
    }

    public function setParameters(array $parameters = array())
    {
        $this->parameters = $parameters;
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
}
