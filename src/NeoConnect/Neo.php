<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace NeoConnect;

use NeoConnect\ServiceContainer\ServiceContainer;

class Neo
{
    private static $serviceContainer;

    private static $logger;


    public static function getServiceContainer()
    {
        if (null === self::$serviceContainer) {
            self::$serviceContainer = new ServiceContainer();
        }

        return self::$serviceContainer;
    }

    public static function getEventDispatcher()
    {
        return self::$serviceContainer->getEventDispatcher();
    }

    public static function sendQuery($query, array $parameters = array(), $connection = null, array $resultDataContents = array())
    {
        return self::$serviceContainer->getNeoKernel()->handleQuery($query, $parameters, $connection, $resultDataContents);
    }


}