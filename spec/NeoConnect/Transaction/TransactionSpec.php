<?php

namespace spec\NeoConnect\Transaction;

use spec\NeoBaseSpec;
use NeoConnect\Connection\Connection,
    NeoConnect\Queue\Queue;

class TransactionSpec extends NeoBaseSpec
{
    function let(Connection $connection, Queue $queue)
    {
        $this->beConstructedWith($connection, $queue);
        $connection->getAlias()->willReturn('default');
        $queue->getStatements()->willReturn(array());
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('NeoConnect\Transaction\Transaction');
    }

    function it_should_have_a_connection_on_construct()
    {
        $this->getConnection()->shouldHaveType('NeoConnect\Connection\Connection');
        $this->getConnection()->getAlias()->shouldReturn('default');
    }

    function it_should_have_a_queue_on_construct()
    {
        $this->getQueue()->shouldHaveType('NeoConnect\Queue\Queue');
    }

    function it_should_create_a_request_based_on_connection_and_queue()
    {
        $this->createRequest()->shouldHaveType('NeoConnect\Request\Request');
    }


}