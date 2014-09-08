<?php

namespace spec\NeoConnect\ServiceContainer;

use spec\NeoBaseSpec;
use NeoConnect\Config\Validator,
    NeoConnect\Connection\ConnectionManager;

class ServiceContainerSpec extends NeoBaseSpec
{
    public function let()
    {

    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('NeoConnect\ServiceContainer\ServiceContainer');
    }

    public function it_should_have_a_container_builder_by_default()
    {
        $this->getServiceContainer()->shouldHaveType('Symfony\Component\DependencyInjection\ContainerBuilder');
    }

    public function it_should_not_have_a_processed_config_by_default()
    {
        $this->getProcessedConfig()->shouldBeNull();
    }

    public function it_should_ask_the_validator_to_validate_the_provided_configuration()
    {
        $config = $this->createConfig();

        $this->loadConfiguration($config)->shouldHaveType('NeoConnect\ServiceContainer\ServiceContainer');
    }

    public function it_should_have_a_processed_config_after_validation()
    {
        $config = $this->createConfig();
        $this->loadConfiguration($config);

        $this->getProcessedConfig()->shouldBeArray();
    }

    public function it_should_load_service_definitions()
    {
        $this->loadServiceDefinitions()->shouldHaveType('NeoConnect\ServiceContainer\ServiceContainer');
    }

    public function it_should_have_service_definition_for()
    {
        $this->loadServiceDefinitions();
        $this->getServiceContainer()->hasDefinition('neoconnect.statement_manager')->shouldReturn(true);
    }

    public function it_should_compile_the_container()
    {
        $this->loadConfiguration($this->createConfig());
        $this->loadServiceDefinitions();
        $this->compile()->shouldHaveType('NeoConnect\ServiceContainer\ServiceContainer');

    }

    public function it_should_build_the_container_in_two_steps()
    {
        $this->loadConfiguration($this->createConfig());
        $this->build()->shouldHaveType('NeoConnect\ServiceContainer\ServiceContainer');
        $this->getServiceContainer()->isFrozen()->shouldReturn(true);
    }

    public function it_should_have_an_event_dispatcher_in_service_definitions()
    {
        $this->loadConfiguration($this->createConfig());
        $this->build();

        $this->getEventDispatcher()->shouldHaveType('Symfony\Component\EventDispatcher\EventDispatcher');
    }

    public function it_should_have_a_shortcut_for_the_connection_manager()
    {
        $this->loadConfiguration($this->createConfig());
        $this->build();
        $this->getConnectionManager()->shouldHaveType('NeoConnect\Connection\ConnectionManager');
    }

    public function it_should_register_connections_based_on_processed_configs()
    {
        $this->loadConfiguration($this->createConfig());
        $this->build();
        $this->getConnectionManager()->getDefaultConnection()->getAlias()->shouldReturn('default');
    }
}
