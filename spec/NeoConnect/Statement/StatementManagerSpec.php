<?php

namespace spec\NeoConnect\Statement;

use spec\NeoBaseSpec;

class StatementManagerSpec extends NeoBaseSpec
{
    function it_is_initializable()
    {
        $this->shouldHaveType('NeoConnect\Statement\StatementManager');
    }

    function it_should_create_a_new_statement_for_a_query()
    {
        $query = 'MATCH (n) RETURN count(n)';
        $this->createStatement($query)->shouldHaveType('NeoConnect\Statement\Statement');
    }
}