<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace NeoConnect\ServiceContainer;

use Symfony\Component\DependencyInjection\ContainerBuilder,
    Symfony\Component\DependencyInjection\Loader\YamlFileLoader,
    Symfony\Component\Config\FileLocator;
use NeoConnect\Config\Validator,
    NeoConnect\ServiceContainer\NeoKernelSubscribersPass;

class ServiceContainer
{
    private $serviceContainer;
    private $processedConfig;

    public function __construct()
    {
        $this->serviceContainer = new ContainerBuilder();
        $this->serviceContainer->addCompilerPass(new NeoKernelSubscribersPass());
    }

    public function getNeoKernel()
    {
        return $this->serviceContainer->get('neoconnect.kernel');
    }

    public function getServiceContainer()
    {
        return $this->serviceContainer;
    }

    public function loadConfiguration($config)
    {
        $validator = new Validator();
        $this->processedConfig = $validator->validate($config);

        return $this;
    }

    public function getProcessedConfig()
    {
        return $this->processedConfig;
    }

    public function loadServiceDefinitions()
    {
        $locator = new FileLocator(array(__DIR__.'/../Resources/config', __DIR__.'/Resources/config/services'));
        $loader = new YamlFileLoader($this->serviceContainer, $locator);

        $loader->load('services.yml');

        return $this;
    }

    public function compile()
    {
        $this->serviceContainer->compile();

        return $this;
    }

    public function build()
    {
        $this->loadServiceDefinitions();
        $this->compile();
        $this->registerConnections();

        return $this;
    }

    public function getEventDispatcher()
    {
        return $this->serviceContainer->get('neoconnect.event_dispatcher');
    }

    public function getConnectionManager()
    {
        return $this->serviceContainer->get('neoconnect.connection_manager');
    }

    public function registerConnections()
    {
        $this->getConnectionManager()->createConnections($this->processedConfig);
    }
}
