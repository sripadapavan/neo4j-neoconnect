<?php

namespace spec\NeoConnect\Queue;

use spec\NeoBaseSpec;
use NeoConnect\Statement\Statement,
    NeoConnect\Connection\Connection;

class QueueSpec extends NeoBaseSpec
{
    public function let()
    {
        $this->beConstructedWith('default');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('NeoConnect\Queue\Queue');
    }

    public function it_should_have_a_connection_alias_reference()
    {
        $this->getConnectionAlias()->shouldReturn('default');
    }

    public function it_should_have_an_empty_array_of_statements_by_default()
    {
        $this->getStatements()->shouldHaveCount(0);
    }

    public function it_should_add_a_statement_to_the_collection()
    {
        $this->addStatement($this->getStatement());
        $this->getStatements()->shouldHaveCount(1);
    }

    public function it_should_have_a_bool_for_empty_state()
    {
        $this->shouldBeEmpty();
        $this->addStatement($this->getStatement());
        $this->shouldNotBeEmpty();
    }

    public function it_should_have_a_get_state_return_code()
    {
        $this->getState()->shouldReturn(0);
        $this->addStatement($this->getStatement());
        $this->getState()->shouldReturn(1);
        $this->addStatement($this->getStatement());
        $this->getState()->shouldReturn(1);
    }

    public function it_should_return_the_amount_of_statements_in_the_queue()
    {
        $this->getCount()->shouldReturn(0);
        for ($i = 0; $i < 10; $i++) {
            $this->addStatement($this->getStatement());
        }
        $this->getCount()->shouldReturn(10);
    }

    private function getStatement()
    {
        $statement = new Statement('match (n) return n');

        return $statement;
    }
}
