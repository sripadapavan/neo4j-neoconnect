<?php

namespace spec\NeoConnect\Connection;

use spec\NeoBaseSpec;

class ConnectionSpec extends NeoBaseSpec
{
    function let()
    {
        $this->beConstructedWith('default');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('NeoConnect\Connection\Connection');
    }

    function it_should_have_a_connection_alias_on_construction()
    {
        $this->getAlias()->shouldNotBeNull();
    }

    function it_should_have_a_scheme_accessor()
    {
        $this->getScheme()->shouldBeNull();
    }

    function its_scheme_should_be_mutable()
    {
        $this->setScheme('http');
        $this->getScheme()->shouldReturn('http');
    }

    function its_scheme_should_be_http_or_https()
    {
        $this->shouldThrow('NeoConnect\Exception\InvalidSchemeException')->duringSetScheme('ftp');
    }

    function it_should_have_a_host_accessor()
    {
        $this->getHost()->shouldBenull();
    }

    function its_host_should_be_mutable()
    {
        $this->setHost('localhost');
        $this->getHost()->shouldReturn('localhost');
    }

    function it_should_have_a_port_accessor()
    {
        $this->getPort()->shouldBeNull();
    }

    function its_port_should_be_mutable()
    {
        $this->setPort(7474);
        $this->getPort()->shouldReturn(7474);
    }

    function it_should_throw_exception_if_port_is_not_integer()
    {
        $this->shouldThrow('\InvalidArgumentException')->duringSetPort('local');
    }

    function it_should_have_a_root_endpoint_accessor()
    {
        $this->getRootEndpoint()->shouldBeNull();
    }

    function its_root_endpoint_should_be_mutable()
    {
        $this->setRootEndpoint('http://localhost:7474');
        $this->getRootEndpoint()->shouldReturn('http://localhost:7474');
    }
}