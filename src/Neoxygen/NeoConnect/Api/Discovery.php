<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace Neoxygen\NeoConnect\Api;

use Neoxygen\NeoConnect\HttpClient\HttpClientInterface,
    Neoxygen\NeoConnect\Deserializer\Deserializer,
    Neoxygen\NeoConnect\Deserializer\Api\RootEndpoint,
    Neoxygen\NeoConnect\Deserializer\Api\ManagementEndpoint;

class Discovery
{
    private $root;
    private $management;
    private $data;
    private $client;
    private $deserializer;

    public function __construct(HttpClientInterface $client, Deserializer $deserializer)
    {
        $this->client = $client;
        $this->deserializer = $deserializer;
    }

    public function processApiDiscovery()
    {
        $this->root = $this->discoverRootEndpoint();
        $this->management = $this->discoverManagementEndpoint($this->root);
        $this->data = $this->discoverDataEndpoint($this->root);
    }

    public function getRootEndpoint()
    {
        return $this->root;
    }

    public function getManagementEndpoint()
    {
        return $this->management;
    }

    public function getDataEndpoint()
    {
        return $this->data;
    }

    private function discoverRootEndpoint()
    {
        $response = $this->client->send('GET');

        return $this->deserializer->deserializeRootEndpoint($response);
    }

    private function discoverManagementEndpoint(RootEndpoint $root)
    {
        $response = $this->client->send('GET', $root->getManagement());

        return $this->deserializer->deserializeManagementEndpoint($response);
    }

    private function discoverDataEndpoint(RootEndpoint $root)
    {
        $response = $this->client->send('GET', $root->getData());

        return $this->deserializer->deserializeDataEndpoint($response);
    }
}
