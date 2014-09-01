<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace Neoxygen\NeoConnect\Transaction;

use Neoxygen\NeoConnect\HttpClient\HttpClientInterface,
    Neoxygen\NeoConnect\Api\Discovery,
    Neoxygen\NeoConnect\Statement\StatementStack,
    Neoxygen\NeoConnect\Statement\Statement,
    Neoxygen\NeoConnect\Statement\StackManager,
    Neoxygen\NeoConnect\Transaction\Strategy\CommitStrategyInterface;

class TransactionManager implements TransactionManagerInterface
{
    protected $commitStrategy;
    protected $httpClient;
    protected $apiDiscovery;
    protected $stackManager;

    /**
     * @param string              $commitStrategy
     * @param null                $stackFlushLimit
     * @param HttpClientInterface $httpClient
     */
    public function __construct(
        StackManager $stackManager,
        CommitStrategyInterface $commitStrategy,
        HttpClientInterface $httpClient,
        Discovery $apiDiscovery)
    {
        $this->commitStrategy = $commitStrategy;
        $this->httpClient = $httpClient;
        $this->apiDiscovery = $apiDiscovery;
        $this->stackManager = $stackManager;
    }

    /**
     * @return string
     */
    public function getCommitStrategy()
    {
        return $this->commitStrategy;
    }

    public function getStackManager()
    {
        return $this->stackManager;
    }

    public function handleStackCommit()
    {
        $stack = $this->getStackManager()->getStack();
        if ($this->getCommitStrategy()->shouldBeFlushed($stack)) {
            $requestBody = $this->getStackManager()->prepareStatementsForFlush();
            $url = $this->apiDiscovery->getDataEndpoint()->getTransaction().'/commit';

            $response = $this->httpClient->send('POST', $url, $requestBody);

            return $response;
        }
    }

    /**
     * @param null $stackFlushLimit
     */
    public function setStackFlushLimit($stackFlushLimit)
    {
        $this->stackFlushLimit = $stackFlushLimit;
    }

    public function begin()
    {

    }

    public function executeStatement()
    {

    }

    public function rollback()
    {

    }

    public function commit()
    {

    }
}
