<?php

namespace Neoxygen\NeoConnect\Tests;

use Neoxygen\NeoConnect\ConnectionBuilder,
    Neoxygen\NeoConnect\Connection,
    Neoxygen\NeoConnect\Statement\StackManager;

class ConnectionTest extends \PHPUnit_Framework_TestCase
{
    public function testFactoryClassReturnsConnectionInstance()
    {
        $conn = ConnectionBuilder::create()->build();
        $this->assertInstanceOf('Neoxygen\NeoConnect\Connection', $conn);
    }

    public function testItHasAServiceContainer()
    {
        $conn = $this->buildDefault();
        $getContainer = self::getMethod('getServiceContainer');
        $container = $getContainer->invoke($conn);
        $this->assertInstanceOf('Symfony\Component\DependencyInjection\Container', $container);
    }

    public function testStackManagerServiceIsAccessible()
    {
        $conn = $this->buildDefault();
        $getStackManager = self::getMethod('getStackManager');
        $sm = $getStackManager->invoke($conn);
        $this->assertInstanceOf('Neoxygen\NeoConnect\Statement\StackManager', $sm);
    }

    public function testParameterBagIsResolved()
    {
        $conn = $this->buildDefault();
        $getContainer = self::getMethod('getServiceContainer');
        $container = $getContainer->invoke($conn);
        $this->assertTrue($container->getParameterBag()->isResolved());
    }

    public function testYouCanGetAParameterValue()
    {
        $conn = $this->buildDefault();
        $this->assertEquals('localhost', $conn->getParameter('neoconnect.connection.host'));
    }

    public function testYouCanGetAllParameters()
    {
        $conn = $this->buildDefault();
        $this->assertTrue(is_array($conn->getParameters()));
    }

    public function testYouCanGetTheNeo4jVersion()
    {
        $conn = $this->buildDefault();
        $this->assertTrue(count(explode('2.', $conn->getNeo4jVersion())) > 1);
    }

    public function testApiDiscoveryServiceIsAccessible()
    {
        $conn = $this->buildDefault();
        $this->assertInstanceOf('Neoxygen\NeoConnect\Api\Discovery', $conn->getApiDiscovery());
    }

    public function testTransactionManagerIsAccessible()
    {
        $conn = $this->buildDefault();
        $this->assertInstanceOf('Neoxygen\NeoConnect\Transaction\TransactionManager', $conn->getTransactionManager());
    }

    public function testServicesAreAccessible()
    {
        $conn = $this->buildDefault();
        $getService = self::getMethod('getService');
        $api = $getService->invokeArgs($conn, array('neoconnect.api_discovery'));
        $this->assertInstanceOf('Neoxygen\NeoConnect\Api\Discovery', $api);
    }

    private function buildDefault()
    {
        return ConnectionBuilder::create()->build();
    }

    protected static function getMethod($name)
    {
        $class = new \ReflectionClass('Neoxygen\NeoConnect\Connection');
        $method = $class->getMethod($name);
        $method->setAccessible(true);

        return $method;
    }
}
