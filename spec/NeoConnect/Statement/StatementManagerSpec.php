<?php

namespace spec\NeoConnect\Statement;

use Prophecy\Argument;
use spec\NeoBaseSpec;
use NeoConnect\Event\NeoKernelEvents\getStatementFromQueryEvent,
    NeoConnect\Statement\Statement;

class StatementManagerSpec extends NeoBaseSpec
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('NeoConnect\Statement\StatementManager');
    }

    public function it_should_implement_event_subscriber_interface()
    {
        $this->shouldImplement('Symfony\Component\EventDispatcher\EventSubscriberInterface');
    }

    public function it_should_create_a_new_statement_for_a_query()
    {
        $query = 'MATCH (n) RETURN count(n)';
        $this->createStatement($query)->shouldHaveType('NeoConnect\Statement\Statement');
    }

    public function it_should_implement_get_subscribed_events_method()
    {
        $this->getSubscribedEvents()->shouldBeArray();
    }

    public function it_should_subscribe_to_neo_kernel_statement_event()
    {
        $this->getSubscribedEvents()->shouldHaveKey('neo_kernel.get_statement_for_query');
    }

    public function it_should_handle_the_event(getStatementFromQueryEvent $event, Statement $statement)
    {
        $event->getQuery()->willReturn('MATCH (n) RETURN n');
        $event->getParameters()->willReturn(array());
        $event->setStatement(Argument::any())->shouldBeCalled();
        $this->transformQueryToStatement($event);
    }
}
