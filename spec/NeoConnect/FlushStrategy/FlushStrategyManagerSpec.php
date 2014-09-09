<?php

namespace spec\NeoConnect\FlushStrategy;

use NeoConnect\Queue\Queue;
use Prophecy\Argument;
use spec\NeoBaseSpec;
use NeoConnect\FlushStrategy\ManualFlushStrategy,
    NeoConnect\Connection\Connection,
    NeoConnect\Queue\QueueManager,
    NeoConnect\Statement\Statement,
    NeoConnect\Event\NeoKernelEvents\applyStrategyForQueueEvent;

class FlushStrategyManagerSpec extends NeoBaseSpec
{
    public function let()
    {
        $this->beConstructedWith();
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType('NeoConnect\FlushStrategy\FlushStrategyManager');
    }

    public function it_should_implement_event_subscriber_interface()
    {
        $this->shouldImplement('Symfony\Component\EventDispatcher\EventSubscriberInterface');
    }

    public function it_should_register_defined_strategy_services(ManualFlushStrategy $strategy)
    {
        $this->registerStrategyService('manual_flush', $strategy);
        $this->getStrategy('manual_flush')->shouldReturn($strategy);
    }

    public function it_should_throw_error_if_strategy_is_already_registered(ManualFlushStrategy $strategy)
    {
        $this->registerStrategyService('manual_flush', $strategy);
        $this->shouldThrow('NeoConnect\Exception\StrategyException')->duringRegisterStrategyService('manual_flush', $strategy);
    }

    public function its_default_strategy_should_be_mutable(ManualFlushStrategy $strategy)
    {
        $this->registerStrategyService('manual_flush', $strategy);
        $this->setDefaultStrategy('manual_flush');
        $this->getDefaultStrategy()->shouldReturn($strategy);
    }

    public function it_should_throw_error_when_defining_unexistent_strategy_as_default(ManualFlushStrategy $strategy)
    {
        $this->registerStrategyService('manual_flush', $strategy);
        $this->shouldThrow('NeoConnect\Exception\StrategyException')->duringSetDefaultStrategy('custom_flush');
    }

    public function it_should_subscribe_to_the_apply_flush_strategy_event()
    {
        $this->getSubscribedEvents()->shouldHaveKey('neo_kernel.apply_flush_strategy');
    }

    function it_should_get_a_strategy_for_connection(ManualFlushStrategy $strategy)
    {
        $this->registerStrategyService('manual_flush', $strategy);
        $this->setDefaultStrategy('manual_flush');
        $conn = new Connection('default');
        $conn->setFlushStrategy('manual_flush');
        $this->findStrategy($conn)->shouldHaveType('NeoConnect\FlushStrategy\ManualFlushStrategy');
    }

    function it_should_ask_the_strategy_for_the_flush(ManualFlushStrategy $strategy)
    {
        $this->registerStrategyService('manual_flush', $strategy);
        $strategy->performFlushDecision(Argument::any(), Argument::any())->willReturn(false);
        $this->applyFlushStrategy($this->getEvent());
        $this->getApplyFlushStrategyEvent()->isFlushOrdered()->shouldReturn(false);
        $this->getApplyFlushStrategyEvent()->isFlushOrdered()->shouldNotBeNull();
    }

    private function getEvent()
    {
        $conn = new Connection('default');
        $conn->setFlushStrategy('manual_flush');
        $st = new Statement('match (n) return n');
        $q = new Queue('default');
        $q->addStatement($st);

        $event = new applyStrategyForQueueEvent($q, $conn);

        return $event;
    }
}
