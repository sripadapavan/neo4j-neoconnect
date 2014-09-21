<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace NeoConnect\Statement;

class Statement
{
    protected $query;
    protected $parameters;
    protected $resultDataContents;

    public function __construct($query, array $parameters = array(), array $resultDataContents = array())
    {
        $this->query = (string) $query;
        $this->parameters = $parameters;
        $this->resultDataContents = $resultDataContents;

        return $this;
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function hasParameters()
    {
        return !empty($this->parameters);
    }

    public function getResultDataContents()
    {
        return $this->resultDataContents;
    }

    public function setQuery($query)
    {
        $this->query = (string) $query;
    }

    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
    }

    public function setResultDataContents(array $resultDataContents)
    {
        $this->resultDataContents = $resultDataContents;
    }

    public function hasResultDataContents()
    {
        return !empty($this->resultDataContents);
    }
}
