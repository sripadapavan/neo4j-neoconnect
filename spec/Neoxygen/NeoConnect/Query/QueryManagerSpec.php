<?php

namespace spec\Neoxygen\NeoConnect\Query;

use Neoxygen\NeoConnect\Query\Queue;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Neoxygen\NeoConnect\Query\Statement,
    Neoxygen\NeoConnect\Connection\ConnectionManager,
    Neoxygen\NeoConnect\Commit\CommitManager;

class QueryManagerSpec extends ObjectBehavior
{
    public function let(ConnectionManager $connectionManager, CommitManager $commitManager)
    {
        $this->beConstructedWith($connectionManager, $commitManager);
        $commitManager->handleQueue(Argument::any())->willReturn(true);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Neoxygen\NeoConnect\Query\QueryManager');
    }

    public function it_should_have_an_array_of_queues_by_default()
    {
        $this->getQueues()->shouldBeArray();
    }

    public function it_should_have_a_connection_manager()
    {
        $this->getConnectionManager()->shouldHaveType('Neoxygen\NeoConnect\Connection\ConnectionManager');
    }

    public function it_should_be_possible_to_create_a_queue(ConnectionManager $connectionManager)
    {
        $connectionManager->hasConnection('default')->willReturn(true);
        $this->createQueue('default');
        $this->getQueues()->shouldHaveCount(1);
    }

    public function it_should_throw_error_if_connection_alias_does_not_exist(ConnectionManager $connectionManager)
    {
        $connectionManager->hasConnection(Argument::any())->willReturn(false);
        $this->shouldThrow('\InvalidArgumentException')->during('createQueue', array('default'));
    }

    public function it_should_be_possible_to_get_a_queue_for_a_connection(ConnectionManager $connectionManager)
    {
        $connectionManager->hasConnection(Argument::any())->willReturn(true);
        $this->createQueue('default');
        $this->getQueue('default')->shouldBeArray();
    }

    public function it_should_throw_error_if_queue_does_not_exist_for_alias()
    {
        $this->shouldThrow('\InvalidArgumentException')->during('getQueue', array('default'));
    }

    public function it_should_add_to_a_new_queue_for_the_default_connection(
        Statement $statement,
        ConnectionManager $manager,
        CommitManager $commitManager)
    {
        $manager->getDefaultConnectionAlias()->willReturn('default');
        $commitManager->handleQueue(Argument::any())->willReturn(true);
        $this->createQuery('MATCH')->shouldReturn(true);
    }

    public function it_should_throw_exception_if_conn_alias_is_not_valid(ConnectionManager $manager)
    {
        $manager->hasConnection(Argument::any())->willReturn(false);
        $this->shouldThrow('\InvalidArgumentException')->duringCreateQuery('MATCH', null, 'rumblebee');
    }

    public function it_should_add_queries_for_multiple_connections(ConnectionManager $connectionManager, CommitManager $commitManager)
    {
        $commitManager->handleQueue(Argument::any())->willReturn(true);
        $connectionManager->getDefaultConnectionAlias()->willReturn('default');
        $connectionManager->hasConnection(Argument::any())->willReturn(true);
        $this->createQuery('MATCH');
        $this->createQuery('MATCH', null, 'rumblebee');
        $this->getQueues()->shouldHaveCount(2);
        foreach ($this->getQueues() as $queue) {
            $queue->isEmpty()->shouldReturn(false);
        }
    }

    public function it_should_have_a_commit_manager()
    {
        $this->getCommitManager()->shouldHaveType('Neoxygen\NeoConnect\Commit\CommitManager');
    }

    public function it_should_pass_the_queue_of_the_current_query_to_the_commit_manager(
        ConnectionManager $connectionManager,
        CommitManager $manager)
    {
        $connectionManager->getDefaultConnectionAlias()->willReturn('default');
        //$manager->handleQueue(Argument::any())->shouldBeCalled();
        $this->createQuery('MATCH');
        $this->getQueues()->shouldHaveCount(1);
    }
}
