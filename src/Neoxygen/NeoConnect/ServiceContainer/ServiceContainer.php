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

    public function build()
    {
        if (!$this->configuration) {
            throw new \RuntimeException('The container can not be built until the configuration is loaded and validated');
        }

        $this->loadServiceDefinitions();
        $this->registerCommitStrategiesClasses();
        $this->compile();
        $this->setConnections();
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

        $this->registerCommitStrategiesClasses();

        return true;
    }

    public function compile()
    {
        if (!$this->configuration || $this->builder->isFrozen()) {
            throw new \RuntimeException('The container is frozen or config is not loaded');
        }

        return $this->builder->compile();
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
            $manager->getConnection($alias)->setCommitStrategy($connection['commit_strategy']['strategy']);
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

    public function registerCommitStrategiesClasses()
    {
        foreach ($this->configuration['class']['commit_strategy'] as $name => $class) {
            $this->builder->setParameter('neoconnect.commit_strategy.'.$name.'.class', $class);
        }

        return true;
    }
}
