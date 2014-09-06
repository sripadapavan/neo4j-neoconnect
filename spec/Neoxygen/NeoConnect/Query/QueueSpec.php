<?php

namespace spec\Neoxygen\NeoConnect\Query;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Neoxygen\NeoConnect\Query\Statement;

class QueueSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('default');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Neoxygen\NeoConnect\Query\Queue');
    }

    function it_should_have_a_connection_alias_by_default()
    {
        $this->getConnectionAlias()->shouldReturn('default');
    }

    function it_should_have_an_empty_array_of_statements_by_default()
    {
        $this->getStatements()->shouldBeArray();
    }

    function it_should_be_possible_to_add_a_statement(Statement $statement)
    {
        $statement->setQuery('MATCH');
        $this->addStatement($statement);
        $this->getStatements()->shouldHaveCount(1);
    }

    function it_should_return_zero_statements_count_when_queue_is_empty()
    {
        $this->getStatementsCount()->shouldReturn(0);
    }

    function it_should_return_non_zero_statements_count_when_queue_is_not_empty(Statement $statement)
    {
        $statement->setQuery('MATCH');
        $this->addStatement($statement);
        $this->getStatementsCount()->shouldReturn(1);
    }

    function it_should_return_empty_state(Statement $statement)
    {
        $this->isEmpty()->shouldReturn(true);
        $this->addStatement($statement);
        $this->isEmpty()->shouldReturn(false);
    }

    function it_should_return_code_for_queue_state(Statement $statement)
    {
        $statement->setQuery('MATCH');
        $this->getState()->shouldReturn(0);
        $this->addStatement($statement);
        $this->getState()->shouldReturn(1);
    }
}
