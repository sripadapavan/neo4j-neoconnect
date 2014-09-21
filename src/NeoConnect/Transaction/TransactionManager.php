<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace NeoConnect\Transaction;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use NeoConnect\Transaction\Transaction,
    NeoConnect\Connection\Connection,
    NeoConnect\Queue\Queue,
    NeoConnect\HttpClient\HttpClientInterface;

class TransactionManager implements EventSubscriberInterface
{
    private $transactions;

    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->transactions = array();
        $this->httpClient = $httpClient;
    }

    public static function getSubscribedEvents()
    {
        return array();
    }

    public function getTransactions()
    {
        return $this->transactions;
    }

    public function createTransaction(Connection $connection, Queue $queue)
    {
        $tx = new Transaction($connection, $queue);
        $this->transactions[$connection->getAlias()] = $tx;

        return $this;
    }

    public function getHttpClient()
    {
        return $this->httpClient;
    }
}
