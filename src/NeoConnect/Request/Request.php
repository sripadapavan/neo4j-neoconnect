<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace NeoConnect\Request;

class Request
{
    private $url;

    private $headers;

    private $options;

    private $method;

    private $body;

    public function __construct()
    {
        $this->headers = array();
        $this->options = array();
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = (string) $url;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function setHeaders(array $headers = array())
    {
        $this->headers = $headers;
    }

    public function setHeader($name, $value)
    {
        $this->headers[$name] = $value;
    }

    public function setOption($name, $value)
    {
        $this->options[$name] = $value;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setMethod($method)
    {
        $this->method = strtoupper($method);
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }
}
