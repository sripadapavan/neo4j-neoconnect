<?php

namespace spec\NeoConnect\FlushStrategy;

use Prophecy\Argument;
use spec\NeoBaseSpec;

class ManualFlushStrategySpec extends NeoBaseSpec
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('NeoConnect\FlushStrategy\AbstractFlushStrategy');
    }

    public function it_should_return_false_for_flush()
    {
        $this->performFlushDecision(Argument::any(), Argument::any())->shouldReturn(false);
    }
}
