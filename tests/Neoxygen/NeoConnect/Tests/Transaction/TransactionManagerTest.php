<?php

namespace Neoxygen\NeoConnect\Tests\Transaction;

use Neoxygen\NeoConnect\Transaction\Strategy\AutoCommitStrategy,
    Neoxygen\NeoConnect\Transaction\Strategy\CommitStrategyInterface,
    Neoxygen\NeoConnect\HttpClient\HttpClient,
    Neoxygen\NeoConnect\Api\Discovery,
    Neoxygen\NeoConnect\Statement\StackManager,
    Neoxygen\NeoConnect\EventDispatcher\EventDispatcher;
use Neoxygen\NeoConnect\Transaction\TransactionManager,
    Neoxygen\NeoConnect\Deserializer\Deserializer,
    Neoxygen\NeoConnect\Deserializer\Api\DataEndpoint;

class TransactionManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testItIsInstatiedCorrectly()
    {
        $this->assertInstanceOf('Neoxygen\NeoConnect\Transaction\TransactionManager', $this->getInstance());
    }

    public function testItReturnsTheCommitStrategy()
    {
        $man = $this->getInstance();
        $this->assertInstanceOf('Neoxygen\NeoConnect\Transaction\Strategy\CommitStrategyInterface', $man->getCommitStrategy());
    }

    public function testItReturnsTheStackManager()
    {
        $man = $this->getInstance();
        $this->assertInstanceOf('Neoxygen\NeoConnect\Statement\StackManager', $man->getStackManager());
    }

    public function testBegin()
    {
        $man = $this->getInstance();
        $this->assertTrue($man->begin());
    }

    public function testCommit()
    {
        $man = $this->getInstance();
        $this->assertTrue($man->commit());
    }

    public function testRollback()
    {
        $man = $this->getInstance();
        $this->assertTrue($man->rollback());
    }

    public function testItAskTheCommitStrategyIfItShouldBeFlushed()
    {
        $man = $this->getInstance();
        $this->assertFalse($man->handleStackCommit());

        $man->getStackManager()->createStatement('MATCH (n:MySupraLabel) RETURN n');
        $response = $man->handleStackCommit();
        $r = json_decode($response, true);
        $this->assertTrue(array_key_exists('results', $r));
    }

    private function getInstance()
    {
        $eventDispatcher = new EventDispatcher();
        $client = new HttpClient('http', 'localhost', 7474, $eventDispatcher);
        $sm = new StackManager($eventDispatcher);
        $deserializer = new Deserializer();
        $api = new Discovery($client, $deserializer);
        $dataE = new DataEndpoint();
        $dataE->setTransaction('http://localhost:7474/db/data/transaction');
        $api->setDataEndpoint($dataE);
        $strategy = new AutoCommitStrategy();

        return new TransactionManager($sm, $strategy, $client, $api);
    }
}
