<?php

namespace spec\NeoConnect\Request;

use Prophecy\Argument;
use spec\NeoBaseSpec;

class RequestSpec extends NeoBaseSpec
{
    function it_is_initializable()
    {
        $this->shouldHaveType('NeoConnect\Request\Request');
    }

    function it_should_have_an_empty_url_by_default()
    {
        $this->getUrl()->shouldBeNull();
    }

    function its_url_should_be_mutabel()
    {
        $this->setUrl('http://localhost:7474/db/data/transaction/commit');
        $this->getUrl()->shouldReturn('http://localhost:7474/db/data/transaction/commit');
    }

    function it_should_have_an_empty_array_of_headers_by_default()
    {
        $this->getHeaders()->shouldHaveCount(0);
    }

    function its_headers_should_be_mutable()
    {
        $this->setHeaders(array('Accept' => 'application/json'));
        $this->getHeaders()->shouldHaveCount(1);
    }

    function it_should_add_additional_headers()
    {
        $this->setHeaders(array('Accept' => 'application/json'));
        $this->setHeader('Content-Type', 'application/json');
        $this->getHeaders()->shouldHaveCount(2);
    }

    function it_should_merge_headers_when_key_is_same()
    {
        $this->setHeaders(array('Accept' => 'application/json'));
        $this->setHeader('Accept', 'application/json');
        $this->getHeaders()->shouldHaveCount(1);
    }

    function it_should_have_an_empty_array_of_connection_options()
    {
        $this->setOption('connection_timeout', 10);
        $this->getOptions()->shouldHaveCount(1);
    }

    function it_should_have_an_empty_method_by_default()
    {
        $this->getMethod()->shouldBeNull();
    }

    function its_method_should_be_mutable()
    {
        $this->setMethod('POST');
        $this->getMethod()->shouldReturn('POST');
    }

    function it_should_capitalize_method_name()
    {
        $this->setMethod('post');
        $this->getMethod()->shouldReturn('POST');
    }

    function its_body_should_be_null_by_default()
    {
        $this->getBody()->shouldBeNull();
    }

    function its_body_should_be_mutable()
    {
        $this->setBody('*');
        $this->getBody()->shouldReturn('*');
    }


}