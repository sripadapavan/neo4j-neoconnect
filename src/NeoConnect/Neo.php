<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace NeoConnect;

use NeoConnect\ServiceContainer\ServiceContainer,
    NeoConnect\NeoEvents;
use Symfony\Component\EventDispatcher\Event;
use Psr\Log\LoggerInterface;

/**
 *
 * This class in the main class you'll work with.
 *
 * You can send queries, have access to different services.
 * This class generally call NeoKernel to perform all the logic of the queries.
 *
 * Class Neo
 * @package NeoConnect
 */
class Neo
{
    const VERSION = '0.7.0-dev';

    /* @var NeoConnect\ServiceContainer\ServiceContainer */
    private static $serviceContainer;

    /* @var Psr\Log\LoggerInterface */
    private static $logger;

    /**
     * Send cypher queries
     * <code>Neo::sendQuery('MATCH (n) RETURN count(n)');</code>
     *
     * @param  string $query              The Cypher Query
     * @param  array  $parameters         The Cypher Query parameters
     * @param  string $connection         The connection alias, if omitted default connection will be used
     * @param  array  $resultDataContents The resultDataContents, an array of values accepting "row", "graph" and "rest"
     * @return mixed  The Queue of the query bounded connection or the Transaction results if the queue has been flushed
     */
    public static function sendQuery($query, array $parameters = array(), $connection = null, array $resultDataContents = array())
    {
        return self::$serviceContainer
            ->getNeoKernel()
            ->handleQuery($query, $parameters, $connection, $resultDataContents);
    }

    /**
     * Access to the Service Container
     * <code>Neo::getServiceContainer();</code>
     *
     * @return NeoConnect\ServiceContainer\ServiceContainer|ServiceContainer
     */
    public static function getServiceContainer()
    {
        if (null === self::$serviceContainer) {
            self::$serviceContainer = new ServiceContainer();
        }

        return self::$serviceContainer;
    }

    /**
     * Accessing the EventDispatcher Service
     * <code>Neo::getEventDispatcher();</code>
     *
     * @return Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher
     */
    public static function getEventDispatcher()
    {
        return self::$serviceContainer->getEventDispatcher();
    }

    /**
     * Accessing a Connection
     * <code>Neo::getConnection('default');<code> - Note that default can be omitted
     *
     * @param $connectionAlias
     * @return NeoConnect\Connection\Connection The Connection corresponding to the alias or the default connection
     *                                          if no alias provided
     */
    public static function getConnection($connectionAlias = null)
    {
        return self::$serviceContainer
            ->getNeoKernel()
            ->getConnection($connectionAlias);
    }

    /**
     * Easily dispatch events from within your application
     * <code>Neo::dispatch(NeoEvents::NEO_KERNEL_FLUSH_STRATEGY, $event);</code>
     *
     * @param $eventConstant The Event constant, for the NeoConnect constants look at the NeoEvents file
     * @param  Event $event
     * @return mixed
     */
    public static function dispatch($eventConstant, Event $event)
    {
        return self::getEventDispatcher()
            ->dispatch($eventConstant, $event);
    }

    public static function getHttpClient()
    {
        return self::$serviceContainer->getHttpClient();
    }

}
