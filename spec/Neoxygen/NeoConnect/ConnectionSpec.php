<?php

namespace spec\Neoxygen\NeoConnect;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\Container;
use Neoxygen\NeoConnect\Transaction\TransactionManager,
    Neoxygen\NeoConnect\Api\Discovery;

class ConnectionSpec extends ObjectBehavior
{

    function let(Container $container, Discovery $discovery, TransactionManager $tm)
    {
        $container->get('neoconnect.api_discovery')->willReturn($discovery);
        $container->get('neoconnect.transaction_manager')->willReturn($tm);
        $this->beConstructedWith($container);

    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Neoxygen\NeoConnect\Connection');
    }

    function it_has_a_api_discovery_service()
    {
        $this->getApiDiscovery()->shouldHaveType('Neoxygen\NeoConnect\Api\Discovery');
    }

    function it_has_a_transaction_manager_service()
    {
        $this->getTransactionManager()->shouldHaveType('Neoxygen\NeoConnect\Transaction\TransactionManager');
    }
}
