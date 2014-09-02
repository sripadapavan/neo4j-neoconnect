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
    Neoxygen\NeoConnect\Statement\StackManager,
    Neoxygen\NeoConnect\Transaction\Strategy\CommitStrategyInterface,
    Neoxygen\NeoConnect\EventDispatcher\EventDispatcher,
    Neoxygen\NeoConnect\Event\GenericLoggingEvent;
use Neoxygen\NeoConnect\NeoConnectEvents;

class TransactionManager implements TransactionManagerInterface
{
    protected $commitStrategy;
    protected $httpClient;
    protected $apiDiscovery;
    protected $stackManager;
    protected $dispatcher;

    /**
     * @param string              $commitStrategy
     * @param null                $stackFlushLimit
     * @param HttpClientInterface $httpClient
     */
    public function __construct(
        StackManager $stackManager,
        CommitStrategyInterface $commitStrategy,
        HttpClientInterface $httpClient,
        Discovery $apiDiscovery,
        EventDispatcher $dispatcher)
    {
        $this->commitStrategy = $commitStrategy;
        $this->httpClient = $httpClient;
        $this->apiDiscovery = $apiDiscovery;
        $this->stackManager = $stackManager;
        $this->dispatcher = $dispatcher;
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
        $this->logEvent('debug', 'Verifying if the Stack should be flushed');
        $this->logEvent('debug', 'Calling the '.$this->commitStrategy->__toString().' Commit Strategy');
        if ($this->getCommitStrategy()->shouldBeFlushed($stack)) {
            $requestBody = $this->getStackManager()->prepareStatementsForFlush();
            $url = $this->apiDiscovery->getDataEndpoint()->getTransaction().'/commit';

            $this->logEvent('info', 'Stack Flush Init - Flushing '.$stack->count().' statement(s)');

            $response = $this->httpClient->send('POST', $url, $requestBody);

            $this->logEvent('info', 'Stack Flush Completed');

            return $response;
        }

        return false;
    }

    public function begin()
    {
        return true;
    }

    public function rollback()
    {
        return true;
    }

    public function commit()
    {
        return true;
    }

    private function logEvent($level, $message)
    {
        $event = new GenericLoggingEvent($message, $level);

        return $this->dispatcher->dispatch(NeoConnectEvents::GENERIC_LOGGING, $event);
    }
}
