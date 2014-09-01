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
    Neoxygen\NeoConnect\EventListener\DefaultHeadersListener,
    Neoxygen\NeoConnect\EventSubscriber\BodyEncodingEventSubscriber;
use Symfony\Component\DependencyInjection\ContainerBuilder,
    Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Psr\Log\LoggerInterface;

class ConnectionBuilder
{
    private $configuration;
    private $serviceContainer;
    private $loggerRegistered;
    private $customLogger;

    public function __construct()
    {
        $this->serviceContainer = new ContainerBuilder();
        $this->configuration = array();
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
        $dispatcher = $this->getContainer()->get('neoconnect.event_dispatcher');
        $logging_subscriber = $this->getContainer()->get('neoconnect.logging_event_subscriber');
        $body_encoding_subscriber = new BodyEncodingEventSubscriber();
        $dispatcher->addSubscriber($logging_subscriber);
        $dispatcher->addSubscriber($body_encoding_subscriber);

        if ($this->loggerRegistered) {
            $this->serviceContainer->get('neoconnect.logger')->setLogger($this->customLogger);
        }
        // Process Neo4j Api Discovery
        $this->serviceContainer->get('neoconnect.api_discovery')->processApiDiscovery();

        return new Connection($this->serviceContainer);
    }

    public function getConfiguration()
    {
        return $this->configuration;
    }

    public function registerLogger(LoggerInterface $logger)
    {
        $this->customLogger = $logger;
        $this->loggerRegistered = true;

        return $this;
    }

    private function registerDefaultExtensions()
    {
        $this->registerAndLoadExtension(new NeoConnectExtension());
    }

    private function registerAndLoadExtension(ExtensionInterface $extension)
    {
        $this->serviceContainer->registerExtension($extension);
        $this->serviceContainer->loadFromExtension($extension->getAlias(), $this->getConfiguration());
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

    public function getContainer()
    {
        return $this->serviceContainer;
    }
}
