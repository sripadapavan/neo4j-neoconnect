<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace Neoxygen\NeoConnect;

use Symfony\Component\DependencyInjection\ContainerInterface;

class Connection implements ConnectionInterface
{
    protected $serviceContainer;

    /**
     * @param $serviceContainer
     */
    public function __construct(ContainerInterface $serviceContainer)
    {
        $this->serviceContainer = $serviceContainer;
    }

    /**
     * @param  string $query
     * @param  array  $parameters
     * @return mixed
     */
    public function sendCypherQuery($query, array $parameters = array())
    {
        $this->getStackManager()->createStatement($query, $parameters);

        return $this->getTransactionManager()->handleStackCommit();
    }

    /**
     * @param $alias
     * @return mixed
     */
    public function getParameter($alias)
    {
        return $this->serviceContainer->getParameter($alias);
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->serviceContainer->getParameterBag()->all();
    }

    /**
     * @return mixed
     */
    public function getNeo4jVersion()
    {
        return $this->getService('neoconnect.api_discovery')->getDataEndpoint()->getNeo4jVersion();
    }

    /**
     * @return Neoxygen\NeoConnect\Api\Discovery The Api Discovery Service
     */
    public function getApiDiscovery()
    {
        return $this->getService('neoconnect.api_discovery');
    }

    /**
     * @return Neoxygen\NeoConnect\Transaction\TransactionManager The Transaction Manager
     */
    public function getTransactionManager()
    {
        return $this->getService('neoconnect.transaction_manager');
    }

    public function getLoggerService()
    {
        return $this->getService('neoconnect.logger');
    }

    /**
     * @param $alias
     * @return mixed
     */
    private function getService($alias)
    {
        return $this->serviceContainer->get($alias);
    }

    private function getStackManager()
    {
        return $this->getService('neoconnect.stack_manager');
    }

    private function getServiceContainer()
    {
        return $this->serviceContainer;
    }
}
