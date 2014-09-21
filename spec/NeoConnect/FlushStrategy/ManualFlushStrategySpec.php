<?php

namespace spec\NeoConnect\FlushStrategy;

use spec\NeoBaseSpec;
use NeoConnect\Queue\Queue;

class ManualFlushStrategySpec extends NeoBaseSpec
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('NeoConnect\FlushStrategy\AbstractFlushStrategy');
    }

    public function it_should_return_false_for_flush()
    {
        $queue = new Queue('default');
        $this->performFlushDecision($queue)->shouldReturn(false);
    }
}
