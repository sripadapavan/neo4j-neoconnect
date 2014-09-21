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
    private $rootEndpoint;
    private $endpoints;
    private $flushStrategy;
    private $defaultEndpoints = array(
        'root' => '/',
        'management' => '/db/management',
        'data' => '/db/data',
        'data.node' => '/db/data/nodes',
        'data.relationships' => '/db/data/relationships',
        'data.transaction' => '/db/data/transaction',
        'data.transaction_single_commit' => '/db/data/transaction/commit',
        'data.transaction_full_commit' => '/db/data/transaction/{id}/commit',
        'data.extensions' => '/db/data/extensions',
        'data.labels' => '/db/data/labels',
        'data.constraints' => '/db/data/schema/constraint',
        'data.indexes' => '/db/data/schema/index',
    );

    public function __construct($alias, $scheme, $host, $port)
    {
        $this->alias = (string) $alias;
        $this->setScheme($scheme);
        $this->setHost($host);
        $this->setPort($port);
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

    public function getRootEndpoint()
    {
        return $this->getEndpoint('root');
    }

    public function getTransactionEndpoint()
    {
        return $this->getEndpoint('data.transaction');
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

    public function getBaseUrl()
    {
        return $this->scheme . '://' .$this->host . ':' .$this->port;
    }

    public function getEndpoints()
    {
        return $this->endpoints;
    }

    private function getEndpoint($key)
    {
        return $this->getBaseUrl() . $this->defaultEndpoints[$key];
    }

    public function getIndexesEndpoint()
    {
        return $this->getEndpoint('data.indexes');
    }

    public function getConstraintsEndpoint()
    {
        return $this->getEndpoint('data.constraints');
    }

    public function getLabelsEndpoint()
    {
        return $this->getEndpoint('data.labels');
    }
}
