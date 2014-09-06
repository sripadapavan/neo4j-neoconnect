<?php

namespace spec\Neoxygen\NeoConnect\Commit;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Neoxygen\NeoConnect\Query\Queue;

class CommitManagerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Neoxygen\NeoConnect\Commit\CommitManager');
    }

    function it_should_register_commit_strategies_for_connections()
    {
        $this->registerCommitStrategy('manual', 'Neoxygen\NeoConnect\Commit\ManualCommitStrategy')->shouldReturn(true);
    }

    function it_should_throw_exception_if_strategy_class_does_not_exist()
    {
        $this->shouldThrow('\InvalidArgumentException')->during('registerCommitStrategy', array(
            'manual',
            'Neoxygen\NeoConnect\Commit\InvalidCommitStrategy'
        ));
    }

    function it_should_handle_a_queue(Queue $queue)
    {
        $this->handleQueue($queue)->shouldReturn(true);
    }
}
