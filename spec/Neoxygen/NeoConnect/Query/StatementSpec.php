<?php

namespace spec\Neoxygen\NeoConnect\Query;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StatementSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Neoxygen\NeoConnect\Query\Statement');
    }

    function it_should_have_a_query_accessor()
    {
        $this->getQuery()->shouldReturn(null);
    }

    function its_query_should_be_mutable()
    {
        $this->setQuery($this->gQuery());
        $this->getQuery()->shouldReturn($this->gQuery());
    }

    function it_should_have_a_parameters_accessor()
    {
        $this->getParameters()->shouldReturn(null);
    }

    function its_parameters_should_be_mutable()
    {
        $this->setParameters(array('hello'));
        $this->getParameters()->shouldReturn(array('hello'));
    }

    private function gQuery()
    {
        return 'MATCH (n) RETURN count(n)';
    }
}
