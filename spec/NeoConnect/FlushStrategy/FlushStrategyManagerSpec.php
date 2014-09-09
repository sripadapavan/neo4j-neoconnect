<?php

namespace spec\NeoConnect\FlushStrategy;

use spec\NeoBaseSpec;
use NeoConnect\FlushStrategy\ManualFlushStrategy;

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
}
