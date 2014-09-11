<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace NeoConnect\Connection;

use NeoConnect\Exception\ConnectionException;
use NeoConnect\Exception\InvalidSchemeException,
    NeoConnect\HttpClient\HttpClientInterface,
    NeoConnect\Discovery\ApiDiscovery;

class Connection
{
    private $allowedSchemes = array('http', 'https');
    private $alias;
    private $scheme;
    private $host;
    private $port;
    private $baseUrl;
    private $rootEndpoint;
    private $flushStrategy;
    private $httpClient;
    private $apiDiscovery;

    public function __construct($alias)
    {
        $this->alias = (string) $alias;
    }

    public function getAlias()
    {
        return $this->alias;
    }

    public function getScheme()
    {
        return $this->scheme;
    }

    public function setScheme($scheme)
    {
        if (!in_array($scheme, $this->allowedSchemes)) {
            throw new InvalidSchemeException(sprintf('The scheme "%s" is not valid. Please use one of "http" or "https', $scheme));
        }
        $this->scheme = (string) $scheme;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function setHost($host)
    {
        $this->host = (string) $host;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function setPort($port)
    {
        if (!is_int($port)) {
            throw new \InvalidArgumentException('Port must be integer');
        }

        $this->port = $port;
    }

    public function getRootEndpoint($discoveryTrigger = false)
    {
        if ($discoveryTrigger && !$this->apiDiscovery) {
            if (null === $this->httpClient) {
                throw new ConnectionException('The HttpClient is not available');
            }
            $this->apiDiscovery = new ApiDiscovery();
            $this->apiDiscovery->processApiDiscovery($this->baseUrl, $this->httpClient);

            return $this->apiDiscovery->getRoot();

        } elseif ($this->apiDiscovery) {

            return $this->apiDiscovery->getRoot();
        }

        return $this->rootEndpoint;
    }

    public function setRootEndpoint($endpoint)
    {
        $this->rootEndpoint = (string) $endpoint;
    }

    public function getFlushStrategy()
    {
        return $this->flushStrategy;
    }

    public function setFlushStrategy($strategy)
    {
        $this->flushStrategy = (string) $strategy;
    }

    public function hasFlushStrategy()
    {
        return null !== $this->flushStrategy;
    }

    public function setHttpClient(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    public function setBaseUrl($url)
    {
        $this->baseUrl = $url;
    }
}
