<?php

namespace spec\Neoxygen\NeoConnect\ServiceContainer;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Neoxygen\NeoConnect\Configuration\ConfigValidator;
use Symfony\Component\Yaml\Yaml;

class ServiceContainerSpec extends ObjectBehavior
{

    function it_is_initializable()
    {
        $this->shouldHaveType('Neoxygen\NeoConnect\ServiceContainer\ServiceContainer');
    }

    function it_should_initialize_a_container_builder()
    {
        $this->getContainerBuilder()->shouldHaveType('Symfony\Component\DependencyInjection\ContainerBuilder');
    }

    function it_should_take_a_config_file_to_load_and_validate(ConfigValidator $validator)
    {
        $config = $this->getConfig();
        $validator->validateConfiguration($config)->willReturn(true);
        $this->loadConfiguration($config)->shouldReturn(true);
    }

    function it_should_return_the_validated_configuration()
    {
        $config = $this->getConfig();
        $this->loadConfiguration($config);
        $this->getConfiguration()->shouldBeArray();
    }

    function it_should_load_the_services_definitions()
    {
        $this->loadServiceDefinitions()->shouldReturn(true);
    }

    function it_should_add_the_connections_to_the_manager()
    {
        $this->loadConfiguration($this->getConfig());
        $this->loadServiceDefinitions();
        $this->setConnections()->shouldReturn(true);
    }

    function it_should_return_me_the_connection_manager()
    {
        $this->loadConfiguration($this->getConfig());
        $this->loadServiceDefinitions();
        $this->setConnections();
        $this->getConnectionManager()->shouldHaveType('Neoxygen\NeoConnect\Connection\ConnectionManager');
        $this->getConnectionManager()->getConnections()->shouldHaveCount(1);
    }

    function it_should_throw_exception_when_try_access_to_connection_manager_before_container_frozing()
    {
        $this->shouldThrow('\InvalidArgumentException')->during('getConnectionManager');
    }

    private function getConfig()
    {
        return getcwd().'/neoconnect.yml';
    }
}
