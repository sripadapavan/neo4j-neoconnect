<?php

namespace spec\Neoxygen\NeoConnect\Connection;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConnectionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('default');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Neoxygen\NeoConnect\Connection\Connection');
    }

    function it_should_have_an_alias()
    {
        $this->getAlias()->shouldReturn('default');
    }

    function its_scheme_should_be_defined_by_default()
    {
        $this->getScheme()->shouldReturn('http');
    }

    function its_scheme_should_be_mutable()
    {
        $this->setScheme('https');
        $this->getScheme()->shouldReturn('https');
    }

    function its_scheme_should_be_http_or_https()
    {
        $this->shouldThrow('\InvalidArgumentException')->during('setScheme', array('rtp'));
    }

    function its_host_should_be_defined_by_default()
    {
        $this->getHost()->shouldReturn('localhost');
    }

    function its_host_should_be_mutable()
    {
        $this->setHost('10.2.2.2');
        $this->getHost()->shouldReturn('10.2.2.2');
    }

    function its_port_should_be_defined_by_default()
    {
        $this->getPort()->shouldReturn(7474);
    }

    function its_port_should_be_mutable()
    {
        $this->setPort(7575);
        $this->getPort()->shouldReturn(7575);
    }

    function its_auth_mode_should_be_false_by_default()
    {
        $this->getAuthMode()->shouldReturn(false);
    }

    function its_auth_mode_should_be_mutable()
    {
        $this->setAuthMode();
        $this->getAuthMode()->shouldReturn(true);
    }

    function its_user_connection_setting_should_be_null_by_default()
    {
        $this->getUser()->shouldBeNull();
    }

    function its_user_should_be_mutable()
    {
        $this->setUser('ikwattro');
        $this->getUser()->shouldReturn('ikwattro');
    }

    function its_password_should_be_null_by_default()
    {
        $this->getPassword()->shouldBeNull();
    }

    function its_password_should_be_mutable()
    {
        $this->setPassword('mySecret');
        $this->getPassword()->shouldReturn('mySecret');
    }
}
