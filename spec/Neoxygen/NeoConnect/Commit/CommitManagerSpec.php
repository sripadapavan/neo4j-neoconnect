<?php

namespace spec\Neoxygen\NeoConnect\Commit;

use Guzzle\Common\Event;
use Neoxygen\NeoConnect\Commit\ManualCommitStrategy;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Neoxygen\NeoConnect\Query\Queue,
    Neoxygen\NeoConnect\Connection\ConnectionManager,
    Neoxygen\NeoConnect\Connection\Connection,
    Neoxygen\NeoConnect\EventDispatcher\CAEventDispatcher,
    Neoxygen\NeoConnect\Event\QueueShouldNotBeFlushedEvent,
    Neoxygen\NeoConnect\NeoConnectEvents;

class CommitManagerSpec extends ObjectBehavior
{
    public function let(ConnectionManager $connectionManager, CAEventDispatcher $eventDispatcher)
    {
        $this->beConstructedWith($connectionManager, $eventDispatcher);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Neoxygen\NeoConnect\Commit\CommitManager');
    }

    public function it_should_have_a_connection_manager()
    {
        $this->hasConnectionManager()->shouldReturn(true);
    }

    public function it_should_register_commit_strategies_for_connections()
    {
        $this->registerCommitStrategy('manual', 'Neoxygen\NeoConnect\Commit\ManualCommitStrategy')->shouldReturn(true);
    }

    public function it_should_throw_exception_if_strategy_class_does_not_exist()
    {
        $this->shouldThrow('\InvalidArgumentException')->during('registerCommitStrategy', array(
            'manual',
            'Neoxygen\NeoConnect\Commit\InvalidCommitStrategy'
        ));
    }

    public function it_should_return_the_corresponding_connection_for_a_queue(Queue $queue, ConnectionManager $connectionManager)
    {
        $queue->getConnectionAlias()->willReturn('default');
        $connectionManager->getConnection(Argument::exact('default'))->willReturn(new Connection('default'));
        $this->getConnectionForQueue($queue)->shouldHaveType('Neoxygen\NeoConnect\Connection\Connection');

    }

    public function it_should_determine_the_strategy_for_queue_connection_alias(Queue $queue, ConnectionManager $connectionManager)
    {
        $this->registerCommitStrategy('manual', 'Neoxygen\NeoConnect\Commit\ManualCommitStrategy');
        $con = new Connection('default');
        $con->setCommitStrategy('manual');
        $queue->getConnectionAlias()->willReturn('default');
        $connectionManager->getConnection('default')->willReturn($con);
        $this->getStrategyForConnection($con)->shouldHaveType('Neoxygen\NeoConnect\Commit\ManualCommitStrategy');
    }

    public function it_should_ask_the_commit_strategy_if_the_queue_should_be_flushed(
        ConnectionManager $connectionManager,
        ManualCommitStrategy $strategy,
        Queue $queue,
        CAEventDispatcher $eventDispatcher)
    {
        $this->registerCommitStrategy('manual', 'Neoxygen\NeoConnect\Commit\ManualCommitStrategy');
        $con = new Connection('default');
        $con->setCommitStrategy('manual');
        $queue->getConnectionAlias()->willReturn('default');
        $connectionManager->getConnection('default')->willReturn($con);
        $strategy->shouldBeFlushed($queue)->willReturn(false);
        $eventDispatcher->dispatch(Argument::any(), Argument::any())->shouldBeCalled();
        $this->handleQueue($queue)->shouldReturn(true);
    }

    public function it_should_dispatch_a_no_flush_report_event(CAEventDispatcher $eventDispatcher)
    {
        $queue = new Queue('default');
        $eventDispatcher->dispatch(Argument::any(), Argument::any())->shouldBeCalled();
        $this->dispatchNoFlush($queue);
    }

    public function it_should_dispatch_a_flush_report_event(CAEventDispatcher $eventDispatcher)
    {
        $queue = new Queue('default');
        $eventDispatcher->dispatch(Argument::any(), Argument::any())->shouldBeCalled();
        $this->dispatchFlush($queue);
    }
}
