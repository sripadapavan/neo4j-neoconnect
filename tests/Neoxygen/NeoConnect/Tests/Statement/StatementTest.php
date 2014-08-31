<?php

namespace Neoxygen\NeoConnect\Tests\Statement;

use Neoxygen\NeoConnect\Statement\Statement;

class StatementTest extends \PHPUnit_Framework_TestCase
{
    public function testItAcceptsQueryAndParametersOnConstruct()
    {
        $q = 'MATCH (n) RETURN n';
        $parameters = array('n' => 'hello');

        $statement = new Statement($q, $parameters);
        $this->assertEquals($statement->getStatement(), $q);
        $this->assertEquals($statement->getParameters(), $parameters);
    }

    public function testStatementIsMutable()
    {
        $q = 'MATCH (n) RETURN n';
        $statement = new Statement($q);
        $q2 = 'MATCH (x) RETURN x';
        $statement->setStatement($q2);
        $this->assertEquals($statement->getStatement(), $q2);

        $rdc = array('row', 'graph');
        $statement->setResultDataContents($rdc);
        $this->assertEquals($statement->getResultDataContents(), $rdc);
    }

    public function testItPreparesStatementForFlush()
    {
        $q = 'MATCH (n) RETURN n';
        $pr = array(
            'statement' => $q
        );
        $st = new Statement($q);
        $this->assertEquals($st->prepare(), $pr);

        $params = array('rows' => 'none');
        $pr['parameters'] = $params;
        $st2 = new Statement($q, $params);
        $this->assertEquals($st2->prepare(), $pr);
        $st2->setResultDataContents(array('row'));
        $pr['resultDataContents'] = array('row');
        $this->assertEquals($st2->prepare(), $pr);

    }
}