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
    Neoxygen\NeoConnect\EventSubscriber\BaseEventSubscriber,
    Neoxygen\NeoConnect\EventSubscriber\BodyEncodingEventSubscriber;
use Symfony\Component\DependencyInjection\ContainerBuilder,
    Symfony\Component\DependencyInjection\Extension\ExtensionInterface,
    Symfony\Component\Yaml\Yaml;
use Psr\Log\LoggerInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class ConnectionBuilder
{
    private $configuration;
    private $serviceContainer;
    private $loggerRegistered;
    private $customLogger;
    private $eventSubscribers;

    public function __construct()
    {
        $this->serviceContainer = new ContainerBuilder();
        $this->configuration = array();
        $this->eventSubscribers = array();
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

    public function loadConfigurationFromFile($file)
    {
        if(!file_exists($file)) {
            throw new \InvalidArgumentException('The file '.$file.' can not be found');
        }
        $config = Yaml::parse($file);
        $this->configuration = $config;

        return $this;

    }

    public function build()
    {
        $this->registerDefaultExtensions();
        $this->compileContainer();

        foreach ($this->configuration['logger'] as $key => $params) {
            $logger = new Logger($key);
            $level = array_search(strtoupper($params['level']), Logger::getLevels());
            $handler = new StreamHandler($params['path'], $level);
            $logger->pushHandler($handler);
            $logService = $this->serviceContainer->get('neoconnect.logger');
            $logService->setLogger($logger);
        }

        $this->registerDefaultListeners();
        $dispatcher = $this->getContainer()->get('neoconnect.event_dispatcher');
        $logging_subscriber = $this->getContainer()->get('neoconnect.logging_event_subscriber');
        $body_encoding_subscriber = new BodyEncodingEventSubscriber();
        $dispatcher->addSubscriber($logging_subscriber);
        $dispatcher->addSubscriber($body_encoding_subscriber);
        $this->registerEventSubscribers();

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

    public function addEventSubscriber(BaseEventSubscriber $subscriber)
    {
        $this->eventSubscribers[] = $subscriber;

        return $this;
    }

    private function registerEventSubscribers()
    {
        $dispatcher = $this->getContainer()->get('neoconnect.event_dispatcher');
        foreach ($this->eventSubscribers as $subscriber) {
            $dispatcher->addSubscriber($subscriber);
        }
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
