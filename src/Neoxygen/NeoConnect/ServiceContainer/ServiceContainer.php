<?php

namespace Neoxygen\NeoConnect\ServiceContainer;

use Symfony\Component\DependencyInjection\ContainerBuilder,
    Symfony\Component\DependencyInjection\Loader\YamlFileLoader,
    Symfony\Component\Config\FileLocator;
use Neoxygen\NeoConnect\Configuration\ConfigValidator,
    Neoxygen\NeoConnect\Connection\ConnectionManager;

class ServiceContainer
{
    protected $builder;
    protected $configuration;
    protected $connectionManager;

    public function __construct()
    {
        $this->builder = new ContainerBuilder();
    }

    public function getContainerBuilder()
    {
        return $this->builder;
    }

    public function loadConfiguration($configFile)
    {
        $validator = new ConfigValidator();
        $this->configuration = $validator->validateConfiguration($configFile);

        return true;
    }

    public function getConfiguration()
    {
        return $this->configuration;
    }

    public function loadServiceDefinitions()
    {
        $locator = new FileLocator(array(__DIR__.'/../Resources/config/services'));
        $loader = new YamlFileLoader($this->builder, $locator);

        $loader->load('services.yml');

        if (count($this->builder->getDefinitions()) === 0) {
            throw new \RuntimeException('Service definitions are not set');
        }
        $this->builder->compile();

        return true;
    }

    public function setConnections()
    {
        $manager = $this->getConnectionManager();
        foreach ($this->configuration['connections'] as $alias => $connection) {
            $manager->createConnection(
                $alias,
                $connection['scheme'],
                $connection['host'],
                $connection['port']
            );
        }

        return true;
    }

    public function getConnectionManager()
    {
        if (!$this->builder->isFrozen()) {
            throw new \InvalidArgumentException('The service can not be accessible while the service container is not compiled');
        }

        if (null === $this->connectionManager) {
            $this->connectionManager = $this->builder->get('neoconnect.connection_manager');
        }

        return $this->connectionManager;
    }
}
