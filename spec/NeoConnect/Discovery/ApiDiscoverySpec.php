<?php

namespace spec\NeoConnect\Discovery;

use Prophecy\Argument;
use spec\NeoBaseSpec;
use NeoConnect\HttpClient\GuzzleHttpClient;

class ApiDiscoverySpec extends NeoBaseSpec
{
    function it_is_initializable()
    {
        $this->shouldHaveType('NeoConnect\Discovery\ApiDiscovery');
    }

    function it_should_not_be_discovered_by_default()
    {
        $this->shouldNotBeDiscovered();
    }

    function it_should_not_have_a_root_by_default()
    {
        $this->getRoot()->shouldBeNull();
    }

    function its_root_should_be_mutable()
    {
        $this->setRoot(array('data' => 'xxx', 'management' => 'xxx'));
        $this->getRoot()->shouldHaveCount(2);
    }

    function it_should_not_have_a_data_endpoint_by_default()
    {
        $this->getData()->shouldBeNull();
    }

    function its_data_endpoint_should_be_mutable()
    {
        $this->setData(array('transaction' => 'xxx'));
        $this->getData()->shouldHaveCount(1);
    }

    function its_management_should_be_empty_by_default()
    {
        $this->getManagement()->shouldBeNull();
    }

    function its_management_should_be_mutable()
    {
        $this->setManagement(array('gmx' => 'xxx'));
        $this->getManagement()->shouldHaveCount(1);
    }

    function it_should_return_true_if_api_has_all_endpoints()
    {
        $this->setRoot(array('hello' => 'me'));
        $this->setData(array('data' => 'xxxx'));
        $this->setManagement(array('cool' => 'pppp'));
        $this->shouldBeDiscovered();
    }

    function it_should_return_false_if_one_enpoint_is_missing()
    {
        $this->setRoot(array('hello' => 'me'));
        $this->shouldNotBeDiscovered();
    }

    function it_should_not_set_the_endpoint_if_array_is_empty()
    {
        $this->setRoot(array('data' => 'xxx'));
        $this->setData(array('transaction' => 'xxx'));
        $this->setManagement(array());
        $this->shouldNotBeDiscovered();
    }

    function it_should_transform_responses_from_an_http_client(GuzzleHttpClient $client)
    {
        $client->send(Argument::any(), Argument::any())->willReturn(array(
            'management' => 'http://localhost:7474/db/manage',
            'data' => 'http://http://localhost:7474/db/data'
        ));
        $this->processApiDiscovery('http://localhost:7474', $client);
        $this->getRoot()->shouldHaveCount(2);
    }
}