<?php

namespace spec\NeoConnect\Transaction;

use spec\NeoBaseSpec;
use NeoConnect\Connection\Connection,
    NeoConnect\Queue\Queue,
    NeoConnect\HttpClient\GuzzleHttpClient;

class TransactionManagerSpec extends NeoBaseSpec
{
    function let(GuzzleHttpClient $client)
    {
        $this->beConstructedWith($client);
    }

    function it_should_have_an_http_client_by_default()
    {
        $this->getHttpClient()->shouldHaveType('NeoConnect\HttpClient\GuzzleHttpClient');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('NeoConnect\Transaction\TransactionManager');
    }

    function it_should_implement_event_subscriber()
    {
        $this->shouldImplement('Symfony\Component\EventDispatcher\EventSubscriberInterface');
    }

    function it_should_have_an_empty_array_of_transactions_by_default()
    {
        $this->getTransactions()->shouldHaveCount(0);
    }

    function it_should_create_new_transactions()
    {
        $this->createTransaction($this->getConnection(), $this->getQueue());
        $this->getTransactions()->shouldHaveCount(1);
    }

    function it_should_sort_transactions_by_connection()
    {
        $this->createTransaction($this->getConnection(), $this->getQueue());
        $this->getTransactions()->shouldHaveKey('default');
    }

    private function getConnection()
    {
        return new Connection('default', 'http', 'localhost', 7474);
    }

    private function getQueue()
    {
        return new Queue($this->getConnection()->getAlias());
    }
}