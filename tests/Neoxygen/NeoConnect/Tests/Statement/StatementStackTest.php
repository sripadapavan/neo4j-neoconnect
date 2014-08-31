<?php

namespace Neoxygen\NeoConnect\Tests\Statement;

use Neoxygen\NeoConnect\Statement\Statement,
    Neoxygen\NeoConnect\Statement\StatementStack;
use Doctrine\Common\Collections\ArrayCollection;

class StatementStackTest extends \PHPUnit_Framework_TestCase
{
    public function testItHaveACollectionOfStackByDefault()
    {
        $stack = new StatementStack();
        $this->assertInstanceOf('Doctrine\Common\Collections\ArrayCollection', $stack->getStatements());
    }

    public function testStackIsEmptyByDefault()
    {
        $stack = new StatementStack();
        $this->assertTrue(0 === $stack->count());
    }

    public function testStatementCanBeAdded()
    {
        $stack = new StatementStack();
        $q = 'MATCH (n) RETURN count(n)';
        $st = new Statement($q);
        $stack->addStatement($st);
        $this->assertTrue($stack->getStatements()->contains($st));
        $this->assertTrue(1 === $stack->count());
    }

    public function testCollectionOfStatementsCanBeSet()
    {
        $stack = new StatementStack();
        $st1 = new Statement('MATCH (n) RETURN n');
        $st2 = new Statement('CREATE (n:Hello) RETURN n');
        $coll = new ArrayCollection();
        $coll->add($st1);
        $coll->add($st2);
        $stack->setStatements($coll);
        $this->assertTrue($stack->getStatements()->contains($st1));
        $this->assertTrue($stack->getStatements()->contains($st2));
    }
}