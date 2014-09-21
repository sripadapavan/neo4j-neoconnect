<?php

namespace spec\NeoConnect\Connection;

use Prophecy\Argument;
use spec\NeoBaseSpec;
use NeoConnect\HttpClient\GuzzleHttpClient;

class ConnectionSpec extends NeoBaseSpec
{
    function let()
    {
        $this->beConstructedWith('default', 'http', 'localhost', 7474);
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
        $this->getScheme()->shouldReturn('http');
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
        $this->getHost()->shouldReturn('localhost');
    }

    function its_host_should_be_mutable()
    {
        $this->setHost('localhost');
        $this->getHost()->shouldReturn('localhost');
    }

    function it_should_have_a_port_accessor()
    {
        $this->getPort()->shouldReturn(7474);
    }

    function its_port_should_be_mutable()
    {
        $this->setPort(7474);
        $this->getPort()->shouldReturn(7474);
    }

    function it_should_build_the_base_url_on_construct()
    {
        $this->getBaseUrl()->shouldReturn('http://localhost:7474');
    }

    function it_should_throw_exception_if_port_is_not_integer()
    {
        $this->shouldThrow('\InvalidArgumentException')->duringSetPort('local');
    }

    function it_should_have_a_root_endpoint_accessor()
    {
        $this->getRootEndpoint()->shouldReturn('http://localhost:7474/');
    }

    function it_should_have_a_flush_strategy_accessor()
    {
        $this->getFlushStrategy()->shouldBeNull();
    }

    function its_flush_strategy_should_be_mutable()
    {
        $this->setFlushStrategy('manual_flush');
        $this->getFlushStrategy()->shouldReturn('manual_flush');
    }

    function it_should_return_the_transaction_endpoint()
    {
        $this->getTransactionEndpoint()->shouldReturn('http://localhost:7474/db/data/transaction');
    }

    function it_should_return_the_indexes_endpoint()
    {
        $this->getIndexesEndpoint()->shouldReturn('http://localhost:7474/db/data/schema/index');
    }

    function it_should_return_the_constraints_endpoint()
    {
        $this->getConstraintsEndpoint()->shouldReturn('http://localhost:7474/db/data/schema/constraint');
    }

    function it_should_return_the_labels_endpoint()
    {
        $this->getLabelsEndpoint()->shouldReturn('http://localhost:7474/db/data/labels');
    }
}
