<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace NeoConnect\Connection;

use NeoConnect\Exception\ConnectionException,
    NeoConnect\Connection\Connection;

class ConnectionManager
{
    private $connections;

    private $defaultConnection;

    public function __construct()
    {
        $this->connections = array();
    }

    public function getConnections()
    {
        return $this->connections;
    }

    public function getDefaultConnection()
    {
        if (empty($this->connections)) {
            throw new ConnectionException(sprintf('There are no connections configured'));
        }

        if (null === $this->defaultConnection) {
            reset($this->connections);

            return current($this->connections);
        }

        return $this->connections[$this->defaultConnection];
    }

    public function createConnections(array $connections = array())
    {
        foreach ($connections['connections'] as $connectionAlias => $settings) {
            $con = new Connection(
                $connectionAlias,
                $settings['scheme'],
                $settings['host'],
                $settings['port']
            );
            $this->connections[$connectionAlias] = $con;
        }
    }

    public function getConnection($connectionAlias = null)
    {
        if (null === $connectionAlias) {
            return $this->getDefaultConnection();
        }

        if (!array_key_exists($connectionAlias, $this->connections)) {
            throw new ConnectionException(sprintf('The connection "%s" is not registered', $connectionAlias));
        }

        return $this->connections[$connectionAlias];
    }

    public function setDefaultConnection($connectionAlias)
    {
        if (!array_key_exists($connectionAlias, $this->connections)) {
            throw new ConnectionException(sprintf('There is no connection for alias "%s"', $connectionAlias));
        }

        $this->defaultConnection = $connectionAlias;
    }

    public function assignFlushStrategy($connectionAlias, $strategyAlias)
    {
        $this->getConnection($connectionAlias)->setFlushStrategy($strategyAlias);
    }

    public function assignDefaultStrategy($defaultStrategy)
    {
        foreach ($this->getConnections() as $connection) {
            if (!$connection->hasFlushStrategy()) {
                $connection->setFlushStrategy($defaultStrategy);
            }
        }
    }
}
