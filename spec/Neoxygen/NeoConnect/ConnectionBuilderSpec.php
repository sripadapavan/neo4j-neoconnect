<?php

namespace spec\Neoxygen\NeoConnect;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConnectionBuilderSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('create', []);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Neoxygen\NeoConnect\ConnectionBuilder');
    }

    function it_should_return_a_connection_instance_when_building()
    {
        $this->build()->shouldHaveType('Neoxygen\NeoConnect\Connection');
    }

    function it_loads_parameters_from_array()
    {
        $config = array('connection' => array('host' => '10.2.2.2'));
        $this->loadConfiguration($config);
        $this->getConfiguration()->shouldReturn($config);
    }
}
