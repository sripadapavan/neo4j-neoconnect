<?php

namespace Neoxygen\NeoConnect\Tests;

use Neoxygen\NeoConnect\ConnectionBuilder;
use Monolog\Logger,
    Monolog\Handler\SyslogHandler;

class ConnectionBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateFactory()
    {
        $create = ConnectionBuilder::create();
        $this->assertInstanceOf('Neoxygen\NeoConnect\ConnectionBuilder', $create);
    }

    public function testCreateInstantiateHttpClient()
    {
        $create = ConnectionBuilder::create();
        $this->assertInstanceOf('Symfony\Component\DependencyInjection\Container', $create->getContainer());
    }

    public function testParameterBagIsNotResolvedWhenCreate()
    {
        $create = ConnectionBuilder::create();
        $this->assertFalse($create->getContainer()->getParameterBag()->isResolved());
    }

    public function testConnectionInstanceIsReturnedWhenBuilding()
    {
        $conn = ConnectionBuilder::create()->build();
        $this->assertInstanceOf('Neoxygen\NeoConnect\Connection', $conn);
    }

    public function testConfigurationisEmptyWhenCreate()
    {
        $builder = $this->getCreateFactory();
        $this->assertTrue(is_array($builder->getConfiguration()));
    }

    public function testConfigurationCanBeLoadedWhileCreatint()
    {
        $builder = $this->getCreateFactory();
        $config = array(
            'connection' => array(
                'host' => '10.2.2.2',
                'port' => 7575
            )
        );
        $builder->loadConfiguration($config);
        $this->assertEquals($config, $builder->getConfiguration());
    }

    public function testConfigurationsCanBeMerged()
    {
        $builder = $this->getCreateFactory();
        $config = array(
            'connection' => array(
                'host' => '10.2.2.2',
                'port' => 7575
            )
        );
        $builder->loadConfiguration($config);
        $config2 = array(
            'connection' => array(
                'host' => 'localhost',
                'port' => 7474
            )
        );
        $builder->loadConfiguration($config2);
        $this->assertEquals($config2, $builder->getConfiguration());
    }

    public function testLoggerIsRegistered()
    {
        $log = new Logger('neoconnect');
        $handler = new SyslogHandler('my_facility', 'local6');
        $log->pushHandler($handler);

        $conn = ConnectionBuilder::create()
            ->registerLogger($log)
            ->build();
        $ls = $conn->getLoggerService();
        $this->assertEquals($log, $ls->getLogger());
    }

    private function getCreateFactory()
    {
        $create = ConnectionBuilder::create();

        return $create;
    }
}
