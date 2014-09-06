<?php

namespace Neoxygen\NeoConnect\Connection;

class Connection
{
    protected $alias;
    protected $scheme;
    protected $host;
    protected $port;
    protected $authMode = false;
    protected $user;
    protected $password;
    protected $commitStrategy;

    public function __construct($alias, $scheme = 'http', $host = 'localhost', $port = 7474)
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

    public function setScheme($scheme)
    {
        if (!in_array($scheme, array('http', 'https'))) {
            throw new \InvalidArgumentException(sprintf('The scheme "%s" is not allowed', $scheme));
        }
        $this->scheme = $scheme;
    }

    public function getScheme()
    {
        return $this->scheme;
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
        $this->port = (int) $port;
    }

    public function getAuthMode()
    {
        return $this->authMode;
    }

    public function setAuthMode()
    {
        $this->authMode = true;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = (string) $user;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = (string) $password;
    }

    public function getCommitStrategy()
    {
        return $this->commitStrategy;
    }

    public function setCommitStrategy($strategy)
    {
        $this->commitStrategy = $strategy;
    }
}
