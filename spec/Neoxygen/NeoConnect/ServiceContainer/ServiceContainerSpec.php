<?php

namespace spec\Neoxygen\NeoConnect\ServiceContainer;

use PhpSpec\ObjectBehavior;
use Neoxygen\NeoConnect\Configuration\ConfigValidator;
use Symfony\Component\Yaml\Yaml,
    Symfony\Component\Filesystem\Filesystem;

class ServiceContainerSpec extends ObjectBehavior
{
    protected $configGenerated = false;

    public function it_is_initializable()
    {
        $this->shouldHaveType('Neoxygen\NeoConnect\ServiceContainer\ServiceContainer');
    }

    public function it_should_initialize_a_container_builder()
    {
        $this->getContainerBuilder()->shouldHaveType('Symfony\Component\DependencyInjection\ContainerBuilder');
    }

    public function it_should_take_a_config_file_to_load_and_validate(ConfigValidator $validator)
    {
        $config = $this->getConfig();
        $validator->validateConfiguration($config)->willReturn(true);
        $this->loadConfiguration($config)->shouldReturn(true);
    }

    public function it_should_return_the_validated_configuration()
    {
        $config = $this->getConfig();
        $this->loadConfiguration($config);
        $this->getConfiguration()->shouldBeArray();
    }

    public function it_should_load_the_services_definitions()
    {
        $this->loadConfiguration($this->getConfig());
        $this->loadServiceDefinitions()->shouldReturn(true);
    }

    public function it_should_add_the_connections_to_the_manager()
    {
        $this->loadConfiguration($this->getConfig());
        $this->loadServiceDefinitions();
        $this->compile();
        $this->setConnections()->shouldReturn(true);
    }

    function it_should_add_the_commit_strategy_to_the_connection()
    {
        $this->loadConfiguration($this->getConfig());
        $this->loadServiceDefinitions();
        $this->compile();
        $this->setConnections();

        $this->getConnectionManager()->getConnection()->getCommitStrategy()->shouldReturn('manual');
    }

    public function it_should_return_me_the_connection_manager()
    {
        $this->loadConfiguration($this->getConfig());
        $this->loadServiceDefinitions();
        $this->compile();
        $this->setConnections();
        $this->getConnectionManager()->shouldHaveType('Neoxygen\NeoConnect\Connection\ConnectionManager');
        $this->getConnectionManager()->getConnections()->shouldHaveCount(1);
    }

    public function it_should_throw_exception_when_try_access_to_connection_manager_before_container_frozing()
    {
        $this->shouldThrow('\InvalidArgumentException')->during('getConnectionManager');
    }

    function it_should_register_the_commit_strategies_classes()
    {
        $this->loadConfiguration($this->getConfig());
        $this->loadServiceDefinitions();
        $this->getContainerBuilder()->getParameter('neoconnect.commit_strategy.manual.class')->shouldReturn(
            'Neoxygen\NeoConnect\Commit\ManualCommitStrategy'
        );
    }

    function it_do_all_in_one()
    {
        $this->loadConfiguration($this->getConfig());
        $this->build();
        $this->getContainerBuilder()->getParameter('neoconnect.commit_strategy.manual.class')->shouldReturn(
            'Neoxygen\NeoConnect\Commit\ManualCommitStrategy'
        );
    }

    private function getConfig()
    {
        if (true === $this->configGenerated) {
            return getcwd().'/neoconnect.yml';
        }

        $fs = new Filesystem();
        if ($fs->exists(getcwd().'/neoconnect.yml')) {
            $fs->remove(getcwd().'/neoconnect.yml');
        }
        $fs->copy(getcwd().'/features/templates/default_config.yml', getcwd().'/neoconnect.yml');
        $this->configGenerated = true;

        return getcwd().'/neoconnect.yml';
    }
}
