<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace Neoxygen\NeoConnect\Statement;

class Statement
{
    protected $statement;
    protected $parameters;
    protected $resultDataContents;

    public function __construct($statement, array $parameters = array())
    {
        $this->setStatement($statement);
        $this->setParameters($parameters);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatement()
    {
        return $this->statement;
    }

    public function setStatement($statement)
    {
        $this->statement = (string) $statement;
    }

    /**
     * @return mixed
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param array $parameters
     */
    public function setParameters(array $parameters = array())
    {
        $this->parameters = $parameters;
    }

    /**
     * @return mixed
     */
    public function getResultDataContents()
    {
        return $this->resultDataContents;
    }

    /**
     * @param mixed $resultDataContents
     */
    public function setResultDataContents(array $resultDataContents = array())
    {
        $this->resultDataContents = $resultDataContents;
    }

    public function prepare()
    {
        $statement =  array(
            'statement' => $this->statement
        );
        if (null !== $this->getParameters() && count($this->getParameters()) > 0) {
            $statement['parameters'] = $this->getParameters();
        }
        if (null !== $this->getResultDataContents() && count($this->getResultDataContents()) > 0) {
            $statement['resultDataContents'] = $this->getResultDataContents();
        }

        return $statement;
    }
}
