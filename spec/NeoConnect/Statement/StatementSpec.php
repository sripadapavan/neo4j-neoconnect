<?php

namespace spec\NeoConnect\Statement;

use spec\NeoBaseSpec;

class StatementSpec extends NeoBaseSpec
{
    public function let()
    {
        $query = 'MATCH (n) RETURN n';
        $this->beConstructedWith($query);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('NeoConnect\Statement\Statement');
    }

    public function it_should_have_a_query_on_construction()
    {
        $this->getQuery()->shouldBeString();
    }

    public function it_should_not_have_parameters_by_default()
    {
        $this->getParameters()->shouldHaveCount(0);
    }

    public function it_should_not_set_parameters_if_parameters_is_empty_array()
    {
        $query = 'MATCH (n) RETURN n';
        $params = array();
        $this->beConstructedWith($query, $params);
        $this->getParameters()->shouldHaveCount(0);
    }

    public function it_should_set_parameters_when_provided()
    {
        $query = 'MATCH (n) RETURN n';
        $params = array('name' => 'marcel');
        $this->beConstructedWith($query, $params);
        $this->getParameters()->shouldBeArray();
        $this->getParameters()->shouldHaveCount(1);
    }

    public function it_should_return_false_if_it_doest_not_has_parameters()
    {
        $this->shouldNotHaveParameters();
    }

    public function it_should_return_true_if_it_has_parameters()
    {
        $q = 'MATCH (n) RETURN n';
        $params = array('name' => 'Roger');
        $this->beConstructedWith($q, $params);
        $this->shouldHaveParameters();
    }

    public function it_should_not_have_result_data_contents_by_default()
    {
        $this->getResultDataContents()->shouldHaveCount(0);
    }

    public function it_should_have_result_data_contents_when_provided()
    {
        $rdc = array('graph', 'row');
        $q = 'MATCH (n) RETURN n';
        $this->beConstructedWith($q, array(), $rdc);
        $this->getResultDataContents()->shouldBeArray();
        $this->getResultDataContents()->shouldHaveCount(2);
    }

    public function its_query_should_be_mutable()
    {
        $this->setQuery('MERGE (x:Label)');
        $this->getQuery()->shouldReturn('MERGE (x:Label)');
    }

    public function its_parameters_should_be_mutable()
    {
        $this->setParameters(array('city' => 'brussels'));
        $this->getParameters()->shouldReturn(array('city' => 'brussels'));
    }

    public function its_result_data_contents_should_be_mutable()
    {
        $this->setResultDataContents(array('row', 'graph'));
        $this->shouldHaveResultDataContents();
        $this->getResultDataContents()->shouldHaveCount(2);
    }
}
