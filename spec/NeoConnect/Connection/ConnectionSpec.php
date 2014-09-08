<?php

namespace spec\NeoConnect\Connection;

use spec\NeoBaseSpec;

class ConnectionSpec extends NeoBaseSpec
{
    public function let()
    {
        $this->beConstructedWith('default');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('NeoConnect\Connection\Connection');
    }

    public function it_should_have_a_connection_alias_on_construction()
    {
        $this->getAlias()->shouldNotBeNull();
    }

    public function it_should_have_a_scheme_accessor()
    {
        $this->getScheme()->shouldBeNull();
    }

    public function its_scheme_should_be_mutable()
    {
        $this->setScheme('http');
        $this->getScheme()->shouldReturn('http');
    }

    public function its_scheme_should_be_http_or_https()
    {
        $this->shouldThrow('NeoConnect\Exception\InvalidSchemeException')->duringSetScheme('ftp');
    }

    public function it_should_have_a_host_accessor()
    {
        $this->getHost()->shouldBenull();
    }

    public function its_host_should_be_mutable()
    {
        $this->setHost('localhost');
        $this->getHost()->shouldReturn('localhost');
    }

    public function it_should_have_a_port_accessor()
    {
        $this->getPort()->shouldBeNull();
    }

    public function its_port_should_be_mutable()
    {
        $this->setPort(7474);
        $this->getPort()->shouldReturn(7474);
    }

    public function it_should_throw_exception_if_port_is_not_integer()
    {
        $this->shouldThrow('\InvalidArgumentException')->duringSetPort('local');
    }

    public function it_should_have_a_root_endpoint_accessor()
    {
        $this->getRootEndpoint()->shouldBeNull();
    }

    public function its_root_endpoint_should_be_mutable()
    {
        $this->setRootEndpoint('http://localhost:7474');
        $this->getRootEndpoint()->shouldReturn('http://localhost:7474');
    }
}
