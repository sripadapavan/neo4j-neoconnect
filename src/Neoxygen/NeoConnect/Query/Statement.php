<?php

namespace Neoxygen\NeoConnect\Query;

class Statement
{
    protected $query;
    protected $parameters;

    public function getQuery()
    {
        return $this->query;
    }

    public function setQuery($query)
    {
        $this->query = (string) $query;
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function setParameters(array $parameters = array())
    {
        if (!is_array($parameters)) {
            throw new \InvalidArgumentException(sprintf('The parameters should be of array type'));
        }

        $this->parameters = $parameters;
    }
}
