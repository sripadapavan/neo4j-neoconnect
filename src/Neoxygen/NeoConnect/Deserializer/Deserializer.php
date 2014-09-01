<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace Neoxygen\NeoConnect\Deserializer;

use JMS\Serializer\SerializerBuilder;
use Doctrine\Common\Annotations\AnnotationRegistry;

class Deserializer
{
    private $serializer;

    /**
     * Constructor
     */
    public function __construct()
    {
        AnnotationRegistry::registerLoader('class_exists');
        $this->serializer = SerializerBuilder::create()->build();

        return $this;
    }

    /**
     * @param  string $jsonString The Json string to be deserialized
     * @param  string $class      The class in which the Json string will be deserialized
     * @return mixed
     */
    public function deserialize($jsonString, $class)
    {
        return $this->serializer->deserialize($jsonString, $class, 'json');
    }

    /**
     * @param  string                                            $json The Json response from the Neo4j API Root endpoint
     * @return Neoxygen\NeoConnect\Deserializer\Api\RootEndpoint The Deserialized Json into RootEndpoint object
     */
    public function deserializeRootEndpoint($json)
    {
        return $this->deserialize($json, 'Neoxygen\NeoConnect\Deserializer\Api\RootEndpoint');
    }

    /**
     * @param  string                                                  $json The Json response from the Neo4j API Management endpoint
     * @return Neoxygen\NeoConnect\Deserializer\Api\ManagementEndpoint The Deserialized Json into Management Endpoint object
     */
    public function deserializeManagementEndpoint($json)
    {
        return $this->deserialize($json, 'Neoxygen\NeoConnect\Deserializer\Api\ManagementEndpoint');
    }

    /**
     * @param  string                                            $json The Json response from the Neo4j API Data Endpoint
     * @return Neoxygen\NeoConnect\Deserializer\Api\DataEndpoint The Deserialized Json into DataEndpoint object
     */
    public function deserializeDataEndpoint($json)
    {
        return $this->deserialize($json, 'Neoxygen\NeoConnect\Deserializer\Api\DataEndpoint');
    }
}
