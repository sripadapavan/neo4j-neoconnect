<?php

namespace Neoxygen\NeoConnect\Tests\Api;

use Neoxygen\NeoConnect\ConnectionBuilder,
    Neoxygen\NeoConnect\Connection,
    Neoxygen\NeoConnect\Statement\StackManager,
    Neoxygen\NeoConnect\Api\Discovery,
    Neoxygen\NeoConnect\EventDispatcher\EventDispatcher;

class DiscoveryTest extends \PHPUnit_Framework_TestCase
{
    protected $discoveryClass = 'Neoxygen\NeoConnect\Api\Discovery';

    public function testItHasAllDependencies()
    {
        $api = $this->getInstance();
        $httpClient = $this->getPrivateProperty($this->discoveryClass, 'client');
        $deserializer = $this->getPrivateProperty($this->discoveryClass, 'deserializer');
        $this->assertInstanceOf('Neoxygen\NeoConnect\HttpClient\HttpClientInterface', $httpClient->getValue($api));
        $this->assertInstanceOf('Neoxygen\NeoConnect\Deserializer\Deserializer', $deserializer->getValue($api));
    }

    public function testApiDiscoveryIsProcessed()
    {
        $api = $this->getInstance();
        $api->processApiDiscovery();
        $this->assertInstanceOf('Neoxygen\NeoConnect\Deserializer\Api\RootEndpoint', $api->getRootEndpoint());
        $this->assertInstanceOf('Neoxygen\NeoConnect\Deserializer\Api\ManagementEndpoint', $api->getManagementEndpoint());
        $this->assertInstanceOf('Neoxygen\NeoConnect\Deserializer\Api\DataEndpoint', $api->getDataEndpoint());
    }

    public function testRootEndpointCanBeSet()
    {
        $api = $this->getInstance();
        $conn = $this->build();
        $root = $conn->getApiDiscovery()->getRootEndpoint();
        $data = $conn->getApiDiscovery()->getDataEndpoint();
        $manangement = $conn->getApiDiscovery()->getManagementEndpoint();

        $api->setDataEndpoint($data);

        $this->assertInstanceOf('Neoxygen\NeoConnect\Api\Discovery', $api->setDataEndpoint($data));
        $this->assertEquals($data, $api->getDataEndpoint());
    }

    public function testRootEndpointIsDiscovered()
    {
        $api = $this->getInstance();
        $discoverRoot = self::getMethod($this->discoveryClass, 'discoverRootEndpoint');
        $root = $discoverRoot->invoke($api);
        $this->assertInstanceOf('Neoxygen\NeoConnect\Deserializer\Api\RootEndpoint', $root);
    }

    public function testManagementEndpointIsDiscovered()
    {
        $api = $this->getInstance();
        $root = $this->getRootEndpoint();
        $discoverManagement = self::getMethod($this->discoveryClass, 'discoverManagementEndpoint');
        $management = $discoverManagement->invokeArgs($api, array($root));
        $this->assertInstanceOf('Neoxygen\NeoConnect\Deserializer\Api\ManagementEndpoint', $management);
    }

    private function build()
    {
        $conn = ConnectionBuilder::create()->build();

        return $conn;
    }

    private function getInstance()
    {
        $conn = $this->build();
        $httpClient = $this->getService('neoconnect.http_client');
        $deserializer = $this->getService('neoconnect.deserializer');
        $dispatcher = new EventDispatcher();

        return new Discovery($httpClient, $deserializer, $dispatcher);
    }

    private function getService($alias)
    {
        $conn = $this->build();
        $getService = self::getMethod('Neoxygen\NeoConnect\Connection', 'getService');
        $service = $getService->invokeArgs($conn, array($alias));

        return $service;
    }

    protected static function getMethod($class, $name)
    {
        $class = new \ReflectionClass($class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);

        return $method;
    }

    private function getPrivateProperty($className, $propertyName)
    {
        $reflector = new \ReflectionClass( $className );
        $property = $reflector->getProperty( $propertyName );
        $property->setAccessible( true );

        return $property;
    }

    private function getRootEndpoint()
    {
        $api = $this->getInstance();
        $discoverRoot = self::getMethod($this->discoveryClass, 'discoverRootEndpoint');
        $root = $discoverRoot->invoke($api);

        return $root;
    }
}
