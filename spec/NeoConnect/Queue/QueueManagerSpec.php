<?php

namespace spec\NeoConnect\Queue;

use Prophecy\Argument;
use spec\NeoBaseSpec;
use NeoConnect\Connection\Connection,
    NeoConnect\Statement\Statement,
    NeoConnect\Event\NeoKernelEvents\getQueueForStatementEvent;

class QueueManagerSpec extends NeoBaseSpec
{
    function it_is_initializable()
    {
        $this->shouldHaveType('NeoConnect\Queue\QueueManager');
    }

    function it_should_implement_event_subscriber_interface()
    {
        $this->shouldImplement('Symfony\Component\EventDispatcher\EventSubscriberInterface');
    }

    function it_should_have_an_empty_array_of_queues_by_default()
    {
        $this->getQueues()->shouldHaveCount(0);
    }

    function it_should_return_bool_if_queue_exist_for_connection()
    {
        $this->shouldNotHaveQueue($this->getConnection());
    }

    function it_should_create_queue_for_connection_if_no_queue_exist()
    {
        $this->createQueue($this->getConnection());
        $this->shouldHaveQueue($this->getConnection());
        $this->getQueues()->shouldHaveCount(1);
    }

    function it_should_return_a_queue_for_a_connection()
    {
        $this->createQueue($this->getConnection());
        $this->getQueue($this->getConnection())->shouldHaveType('NeoConnect\Queue\Queue');
    }

    function it_should_throw_error_if_queue_for_connection_not_exist_when_demanding_queue()
    {
        $this->shouldThrow('\InvalidArgumentException')->duringGetQueue($this->getConnection());
    }

    function it_should_return_the_queue_if_alias_exist_or_not()
    {
        $this->createQueue($this->getConnection());
        $this->getQueues()->shouldHaveCount(1);
        $this->createQueue($this->getConnection());
        $this->getQueues()->shouldHaveCount(1);
        $this->createQueue($this->getConnection())->shouldHaveType('NeoConnect\Queue\Queue');
    }

    function it_should_return_queue_state_code_for_connection()
    {
        $this->getQueueState($this->getConnection())->shouldReturn(0);
        $this->createQueue($this->getConnection());
        $this->getQueueState($this->getConnection())->shouldReturn(0);
    }

    function it_should_return_queue_for_string_connection_alias()
    {
        $this->getQueueForAlias('default')->shouldBeNull();
        $this->createQueue($this->getConnection());
        $this->getQueueForAlias('default')->shouldHaveType('NeoConnect\Queue\Queue');
    }

    function it_should_handle_a_get_queue_for_statement_event()
    {
        $ev = $this->getEvent();
        $this->getQueueForStatement($ev);
        $this->getQueues()->shouldHaveCount(1);
        $this->getQueueState($ev->getConnection())->shouldReturn(1);
    }

    function it_should_subscribe_to_the_queue_kernel_event()
    {
        $this->getSubscribedEvents()->shouldHaveKey('neo_kernel.get_queue_for_statement');
    }

    private function getEvent()
    {
        $st = $this->getStatement();
        $conn = $this->getConnection();
        $event = new getQueueForStatementEvent($st, $conn);

        return $event;
    }

    private function getConnection()
    {
        $conn = new Connection('default');

        return $conn;
    }

    private function getStatement()
    {
        return new Statement('match (n) return n');
    }
}
