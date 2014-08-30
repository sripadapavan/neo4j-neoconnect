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
    Neoxygen\NeoConnect\Transaction\StatementStack,
    Neoxygen\NeoConnect\Transaction\Statement;

class TransactionManager implements TransactionManagerInterface
{
    protected $commitStrategy;
    protected $stackFlushLimit;
    protected $stack;
    protected $httpClient;
    protected $apiDiscovery;

    /**
     * @param string              $commitStrategy
     * @param null                $stackFlushLimit
     * @param HttpClientInterface $httpClient
     */
    public function __construct(
        $commitStrategy = 'auto',
        $stackFlushLimit = null,
        HttpClientInterface $httpClient,
        Discovery $apiDiscovery)
    {
        $this->commitStrategy = $commitStrategy;
        $this->stackFlushLimit = $stackFlushLimit;
        $this->httpClient = $httpClient;
        $this->apiDiscovery = $apiDiscovery;
        $this->stack = new StatementStack();
    }

    /**
     * @return string
     */
    public function getCommitStrategy()
    {
        return $this->commitStrategy;
    }

    /**
     * @param string $commitStrategy
     */
    public function setCommitStrategy($commitStrategy)
    {
        $this->commitStrategy = $commitStrategy;
    }

    /**
     * @return null
     */
    public function getStackFlushLimit()
    {
        return $this->stackFlushLimit;
    }

    /**
     * @return mixed
     */
    public function getStack()
    {
        return $this->stack;
    }

    public function createStatement($query, array $parameters = array())
    {
        $statement = new Statement($query, $parameters);
        $this->stack->addStatement($statement);

        return $this->flushStack();
    }

    public function flushStack()
    {
        $sts = array('statements' => array());
        if (0 !== $this->stack->count()) {
            foreach ($this->stack->getStatements() as $statetement) {
                $sts['statements'][] = $statetement->prepare();
            }
        }
        $url = $this->apiDiscovery->getDataEndpoint()->getTransaction().'/commit';

        return $this->httpClient->send('POST', $url, $sts);
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
