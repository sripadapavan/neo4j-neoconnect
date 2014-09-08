<?php

namespace spec\NeoConnect\Statement;

use Prophecy\Argument;
use spec\NeoBaseSpec;
use NeoConnect\Event\NeoKernelEvents\getStatementFromQueryEvent,
    NeoConnect\Statement\Statement;

class StatementManagerSpec extends NeoBaseSpec
{
    function it_is_initializable()
    {
        $this->shouldHaveType('NeoConnect\Statement\StatementManager');
    }

    function it_should_implement_event_subscriber_interface()
    {
        $this->shouldImplement('Symfony\Component\EventDispatcher\EventSubscriberInterface');
    }

    function it_should_create_a_new_statement_for_a_query()
    {
        $query = 'MATCH (n) RETURN count(n)';
        $this->createStatement($query)->shouldHaveType('NeoConnect\Statement\Statement');
    }

    function it_should_implement_get_subscribed_events_method()
    {
        $this->getSubscribedEvents()->shouldBeArray();
    }

    function it_should_subscribe_to_neo_kernel_statement_event()
    {
        $this->getSubscribedEvents()->shouldHaveKey('neo_kernel.query_handler.transform_to_statement');
    }

    function it_should_handle_the_event(getStatementFromQueryEvent $event, Statement $statement)
    {
        $event->getQuery()->willReturn('MATCH (n) RETURN n');
        $event->getParameters()->willReturn(array());
        $event->setStatement(Argument::any())->shouldBeCalled();
        $this->transformQueryToStatement($event);
    }
}