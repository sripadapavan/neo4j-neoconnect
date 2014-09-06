<?php

namespace spec\Neoxygen\NeoConnect\Connection;

use PhpSpec\ObjectBehavior;
use Neoxygen\NeoConnect\HttpClient\HttpClient,
    Neoxygen\NeoConnect\Connection\Connection;

class ConnectionManagerSpec extends ObjectBehavior
{
    public function let(HttpClient $client)
    {
        $this->beConstructedWith($client);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Neoxygen\NeoConnect\Connection\ConnectionManager');
    }

    public function it_should_have_an_empty_array_of_connections()
    {
        $this->getConnections()->shouldHaveCount(0);
    }

    public function it_should_have_an_http_client_by_default()
    {
        $this->getHttpClient()->shouldHaveType('Neoxygen\NeoConnect\HttpClient\HttpClientInterface');
    }

    public function it_should_create_a_new_connection()
    {
        $this->createConnection('default', 'http', 'localhost', 7474);
        $this->getConnections()->shouldHaveCount(1);
    }

    public function it_should_manage_multiple_connections()
    {
        $this->createConnection('default');
        $this->createConnection('custom');
        $this->getConnections()->shouldHaveCount(2);
    }

    public function it_should_throw_exception_if_connection_with_alias_already_exist()
    {
        $this->createConnection('default');
        $this->shouldThrow('\InvalidArgumentException')->during('createConnection', array('default'));
    }

    public function its_default_connection_should_be_empty_by_default()
    {
        $this->getDefaultConnection()->shouldBeNull();
    }

    public function it_should_set_user_defined_default_connection()
    {
        $this->createConnection('custom');
        $this->setDefaultConnection('custom')->shouldReturn(true);
    }

    public function it_should_throw_error_if_alias_for_default_connection_does_not_exist()
    {
        $this->createConnection('custom');
        $this->shouldThrow('\InvalidArgumentException')->during('setDefaultConnection', array('default'));
    }

    public function it_should_return_first_connection_if_default_is_not_set_when_calling_get_default_connection()
    {
        $this->createConnection('custom');
        $this->createConnection('user');
        $this->getDefaultConnection()->getAlias()->shouldReturn('custom');
    }

    public function it_should_return_connection_for_alias()
    {
        $this->createConnection('custom');
        $this->createConnection('user');
        $this->getConnection('custom')->getAlias()->shouldReturn('custom');
    }

    public function it_should_throw_error_if_connection_with_alias_does_not_exist()
    {
        $this->createConnection('custom');
        $this->shouldThrow('\InvalidArgumentException')->during('getConnection', array('user'));
    }

    public function it_should_return_me_the_default_connection_if_i_do_not_specify_the_alias()
    {
        $this->createConnection('default');
        $this->createConnection('custom');
        $this->getConnection()->shouldHaveType('Neoxygen\NeoConnect\Connection\Connection');
        $this->getConnection()->getAlias()->shouldReturn('default');
    }

    public function it_should_return_bool_when_asking_if_a_connection_exist()
    {
        $this->createConnection('default');
        $this->hasConnection('default')->shouldReturn(true);
        $this->hasConnection('coool')->shouldReturn(false);
    }
}
