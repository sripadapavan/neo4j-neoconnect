<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace Neoxygen\NeoConnect;

class Connection implements ConnectionInterface
{
    protected $serviceContainer;

    public function __construct($serviceContainer)
    {
        $this->serviceContainer = $serviceContainer;
    }

    public function sendCypherQuery($query, $parameters)
    {

    }

    public function getParameter($alias)
    {
        return $this->serviceContainer->getParameter($alias);
    }

    public function getParameters()
    {
        return $this->serviceContainer->getParameterBag();
    }

    public function getNeo4jVersion()
    {
        return $this->getService('neoconnect.api_discovery')->getDataEndpoint()->getNeo4jVersion();
    }

    public function getApiDiscovery()
    {
        return $this->getService('neoconnect.api_discovery');
    }

    private function getService($alias)
    {
        return $this->serviceContainer->get($alias);
    }
}
