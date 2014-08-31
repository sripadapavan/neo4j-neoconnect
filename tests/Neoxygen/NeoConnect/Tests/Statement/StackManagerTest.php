<?php

namespace Neoxygen\NeoConnect\Tests\Statement;

use Neoxygen\NeoConnect\Statement\Statement,
    Neoxygen\NeoConnect\Statement\StatementStack,
    Neoxygen\NeoConnect\Statement\StackManager;
use Doctrine\Common\Collections\ArrayCollection;

class StackManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testItContainsAnEmptyStackByDefault()
    {
        $manager = new StackManager();
        $this->assertInstanceOf('Neoxygen\NeoConnect\Statement\StatementStack', $manager->getStack());
        $this->assertTrue(0 === $manager->getStack()->count());
    }

    public function testItReturnsACollectionOfStatements()
    {
        $manager = new StackManager();
        $this->assertInstanceOf('Doctrine\Common\Collections\ArrayCollection', $manager->getStatements());
    }

    public function testStatementCanBeAddedToStack()
    {
        $manager = new StackManager();
        $st = new Statement('MATCH (n) RETURN n');
        $manager->addStatement($st);
        $this->assertTrue($manager->getStatements()->contains($st));
    }

    public function testStatementIsCreatedFromQueryAndAddedToStack()
    {
        $q = 'MATCH (h) RETURN h';
        $manager = new StackManager();
        $manager->createStatement($q);
        $this->assertEquals(1, $manager->getStack()->count());
    }

    public function testStatementsArePreparedForFlush()
    {
        $expected = array('statements' => array(
            array('statement' => 'MATCH (n) RETURN n')

        ));
        $manager = new StackManager();
        $manager->createStatement('MATCH (n) RETURN n');
        $prepared = $manager->prepareStatementsForFlush();
        $this->assertEquals($expected, $prepared);
    }
}