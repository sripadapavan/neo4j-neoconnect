<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace NeoConnect\Connection;

use NeoConnect\Exception\InvalidSchemeException;

class Connection
{
    private $allowedSchemes = array('http', 'https');
    private $alias;
    private $scheme;
    private $host;
    private $port;
    private $rootEndpoint;

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

    public function getRootEndpoint()
    {
        return $this->rootEndpoint;
    }

    public function setRootEndpoint($endpoint)
    {
        $this->rootEndpoint = (string) $endpoint;
    }
}
