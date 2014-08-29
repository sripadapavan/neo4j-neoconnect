<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace Neoxygen\NeoConnect;

use Neoxygen\NeoConnect\Connection,
    Neoxygen\NeoConnect\DependencyInjection\NeoConnectExtension,
    Neoxygen\NeoConnect\EventListener\DefaultHeadersListener;
use Symfony\Component\DependencyInjection\ContainerBuilder,
    Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

class ConnectionBuilder
{
    private $configuration;
    private $serviceContainer;

    public function __construct()
    {
        $this->serviceContainer = new ContainerBuilder();
    }

    public static function create()
    {
        return new static();
    }

    public function loadConfiguration(array $config)
    {
        $configuration = (null !== $this->configuration && is_array($this->configuration)) ? $this->configuration : array();
        $this->configuration = array_merge($configuration, $config);

        return $this;
    }

    public function build()
    {
        $this->registerDefaultExtensions();
        $this->compileContainer();
        $this->registerDefaultListeners();

        // Process Neo4j Api Discovery
        $this->serviceContainer->get('neoconnect.api_discovery')->processApiDiscovery();

        return new Connection($this->serviceContainer);
    }

    public function getConfiguration($defaultArray = false)
    {
        if (null === $this->configuration && $defaultArray) {
            return array();
        }

        return $this->configuration;
    }

    private function registerDefaultExtensions()
    {
        $this->registerAndLoadExtension(new NeoConnectExtension());
    }

    private function registerAndLoadExtension(ExtensionInterface $extension)
    {
        $this->serviceContainer->registerExtension($extension);
        $this->serviceContainer->loadFromExtension($extension->getAlias(), $this->getConfiguration(true));
    }

    private function compileContainer()
    {
        return $this->serviceContainer->compile();
    }

    private function registerDefaultListeners()
    {
        $defaultsHeadersListener = new DefaultHeadersListener();
        $this->serviceContainer->get('neoconnect.event_dispatcher')->addListener('pre_request.send', array(
            $defaultsHeadersListener, 'onPreRequestSend'
        ));
    }
}