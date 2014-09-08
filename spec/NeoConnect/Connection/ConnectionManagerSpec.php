<?php

namespace spec\NeoConnect\Connection;

use spec\NeoBaseSpec;

class ConnectionManagerSpec extends NeoBaseSpec
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('NeoConnect\Connection\ConnectionManager');
    }

    public function it_should_have_an_empty_array_of_connections_by_default()
    {
        $this->getConnections()->shouldHaveCount(0);
    }

    public function it_should_not_have_a_default_connection_by_default()
    {
        $this->shouldThrow('NeoConnect\Exception\ConnectionException')->duringGetDefaultConnection();
    }

    public function it_should_create_new_connections_based_on_config_array()
    {
        $this->createConnections($this->getMultipleConnectionsArray());
        $this->getConnections()->shouldHaveCount(2);
    }

    public function it_should_return_the_connection_for_alias()
    {
        $this->createConnections($this->getMultipleConnectionsArray());
        $this->getConnection('default')->shouldHaveType('NeoConnect\Connection\Connection');
    }

    public function it_should_throw_error_if_connection_does_not_exist_for_alias()
    {
        $this->createConnections($this->getMultipleConnectionsArray());
        $this->shouldThrow('NeoConnect\Exception\ConnectionException')->duringGetConnection('custom');
    }

    public function it_should_return_the_first_registered_connection_when_no_default_is_provided()
    {
        $this->createConnections($this->getMultipleConnectionsArray());
        $this->getDefaultConnection()->getAlias()->shouldReturn('default');

    }

    public function it_should_mark_a_connection_as_default_when_user_provide_it()
    {
        $this->createConnections($this->getMultipleConnectionsArray());
        $this->setDefaultConnection('stats');
        $this->getDefaultConnection()->getAlias()->shouldReturn('stats');
    }

    public function it_should_throw_errors_if_connection_does_not_exist_for_default_alias()
    {
        $this->createConnections($this->getMultipleConnectionsArray());
        $this->shouldThrow('NeoConnect\Exception\ConnectionException')->duringSetDefaultConnection('hello');
    }

    public function it_should_return_default_connection_for_get_connection_without_alias()
    {
        $this->createConnections($this->getMultipleConnectionsArray());
        $this->setDefaultConnection('stats');
        $this->getConnection()->getAlias()->shouldReturn('stats');
    }

    private function getMultipleConnectionsArray()
    {
        $connections = array(
            'connections' => array(
                'default' => array(
                    'scheme' => 'http',
                    'host' => 'localhost',
                    'port' => 7474
                ),
                'stats' => array(
                    'scheme' => 'http',
                    'host' => 'stats.localgraphs.dev',
                    'port' => 7474
                )
            )
        );

        return $connections;
    }
}
