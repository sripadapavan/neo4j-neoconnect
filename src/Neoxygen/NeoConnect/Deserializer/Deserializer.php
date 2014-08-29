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
use Neoxygen\NeoConnect\Deserializer\Api\RootEndpoint;

class Deserializer
{
    private $serializer;

    public function __construct()
    {
        AnnotationRegistry::registerLoader('class_exists');
        $this->serializer = SerializerBuilder::create()->build();

        return $this;
    }

    public function deserialize($jsonString, $class)
    {
        return $this->serializer->deserialize($jsonString, $class, 'json');
    }

    public function deserializeRootEndpoint($json)
    {
        return $this->deserialize($json, 'Neoxygen\NeoConnect\Deserializer\Api\RootEndpoint');
    }

    public function deserializeManagementEndpoint($json)
    {
        return $this->deserialize($json, 'Neoxygen\NeoConnect\Deserializer\Api\ManagementEndpoint');
    }

    public function deserializeDataEndpoint($json)
    {
        //var_dump($json);
        return $this->deserialize($json, 'Neoxygen\NeoConnect\Deserializer\Api\DataEndpoint');
    }
}
