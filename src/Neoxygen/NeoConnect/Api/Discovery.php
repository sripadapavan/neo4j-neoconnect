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
    Neoxygen\NeoConnect\Deserializer\Api\DataEndpoint;

class Discovery
{
    private $root;
    private $management;
    private $data;
    private $client;
    private $deserializer;

    /**
     * @param  HttpClientInterface               $client
     * @param  Deserializer                      $deserializer
     * @return Neoxygen\NeoConnect\Api\Discovery
     */
    public function __construct(HttpClientInterface $client, Deserializer $deserializer)
    {
        $this->client = $client;
        $this->deserializer = $deserializer;

        return $this;
    }

    /**
     * @return Neoxygen\NeoConnect\Api\Discovery $this
     */
    public function processApiDiscovery()
    {
        $this->root = $this->discoverRootEndpoint();
        $this->management = $this->discoverManagementEndpoint($this->root);
        $this->data = $this->discoverDataEndpoint($this->root);

        return $this;
    }

    /**
     * @return Neoxygen\NeoConnect\Deserializer\Api\RootEndpoint
     */
    public function getRootEndpoint()
    {
        return $this->root;
    }

    /**
     * @return Neoxygen\NeoConnect\Deserializer\Api\ManagementEndpoint
     */
    public function getManagementEndpoint()
    {
        return $this->management;
    }

    /**
     * @return Neoxygen\NeoConnect\Deserializer\Api\DataEndpoint
     */
    public function getDataEndpoint()
    {
        return $this->data;
    }

    /**
     * @param  DataEndpoint                      $dataEndpoint
     * @return Neoxygen\NeoConnect\Api\Discovery
     */
    public function setDataEndpoint(DataEndpoint $dataEndpoint)
    {
        $this->data = $dataEndpoint;

        return $this;
    }

    /**
     * @return Neoxygen\NeoConnect\Deserializer\Api\RootEndpoint
     */
    private function discoverRootEndpoint()
    {
        $response = $this->client->send('GET');

        return $this->deserializer->deserializeRootEndpoint($response);
    }

    /**
     * @param  RootEndpoint                                            $root
     * @return Neoxygen\NeoConnect\Deserializer\Api\ManagementEndpoint
     */
    private function discoverManagementEndpoint(RootEndpoint $root)
    {
        $response = $this->client->send('GET', $root->getManagement());

        return $this->deserializer->deserializeManagementEndpoint($response);
    }

    /**
     * @param  RootEndpoint                                      $root
     * @return Neoxygen\NeoConnect\Deserializer\Api\DataEndpoint
     */
    private function discoverDataEndpoint(RootEndpoint $root)
    {
        $response = $this->client->send('GET', $root->getData());

        return $this->deserializer->deserializeDataEndpoint($response);
    }
}
