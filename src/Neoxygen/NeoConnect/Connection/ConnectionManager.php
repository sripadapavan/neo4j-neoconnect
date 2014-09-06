<?php

namespace Neoxygen\NeoConnect\Connection;

use Neoxygen\NeoConnect\HttpClient\HttpClientInterface,
    Neoxygen\NeoConnect\Connection\Connection;

class ConnectionManager
{

    protected $httpClientClass;
    protected $client;
    protected $defaultConnection;

    public function __construct($httpClientClass)
    {
        $this->httpClientClass = $httpClientClass;
    }

    protected $connections = array();

    public function getConnections()
    {
        return $this->connections;
    }

    public function getHttpClient()
    {
        if (null === $this->client) {
            $this->client = new $this->httpClientClass();
        }

        return $this->client;
    }

    public function createConnection($alias, $scheme = 'http', $host = 'localhost', $port = 7474)
    {
        $connection = new Connection($alias, $scheme, $host, $port);
        if (array_key_exists($alias, $this->connections)) {
            throw new \InvalidArgumentException(sprintf('A connection already exist with alias "%s"', $alias));
        }
        $this->connections[$alias] = $connection;
    }

    public function getDefaultConnection()
    {
        if (empty($this->connections)) {
            return null;
        }

        if (null === $this->defaultConnection) {
            reset($this->connections);

            return current($this->connections);
        }

        return $this->connections[$this->defaultConnection];
    }

    public function setDefaultConnection($alias)
    {
        if (!array_key_exists($alias, $this->connections)) {
            throw new \InvalidArgumentException(sprintf('There is no connection configured for alias "%s"', $alias));
        }
        $this->defaultConnection = $alias;

        return true;
    }

    public function getConnection($alias = null)
    {
        if (null === $alias) {
            return $this->getDefaultConnection();
        }

        if (!array_key_exists($alias, $this->connections)) {
            throw new \InvalidArgumentException(sprintf('Connection with alias "%s" does not exist', $alias));
        }

        return $this->connections[$alias];
    }
}
