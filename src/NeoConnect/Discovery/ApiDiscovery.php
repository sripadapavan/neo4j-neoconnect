<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace NeoConnect\Discovery;

use NeoConnect\HttpClient\HttpClientInterface;

class ApiDiscovery
{
    private $discovered;

    private $root;

    private $data;

    private $management;

    private $connectionAlias;

    public function getConnectionAlias()
    {
        return $this->connectionAlias;
    }

    public function isDiscovered()
    {
        if (true === $this->discovered) {

            return $this->discovered;
        }

        if (!empty($this->root) && !empty($this->data) && !empty($this->management)) {
            $this->discovered = true;
        }

        return null !== $this->discovered;
    }

    public function getRoot()
    {
        return $this->root;
    }

    public function setRoot(array $rootEndpoint)
    {
        $this->root = $rootEndpoint;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData(array $dataEndpoint)
    {
        $this->data = $dataEndpoint;
    }

    public function getManagement()
    {
        return $this->management;
    }

    public function setManagement(array $managementEndpoint)
    {
        $this->management = $managementEndpoint;
    }

    public function processApiDiscovery($baseUrl, HttpClientInterface $client)
    {
        $root = $client->send('GET', $baseUrl);
        $this->root = $root;

        $mgmUrl = $this->root['management'];
        $mgm = $client->send('GET', $mgmUrl);
        $this->management = $mgm;

        $dataUrl = $this->root['data'];
        $data = $client->send('GET', $dataUrl);
        $this->data = $data;

        return $this;

    }
}
