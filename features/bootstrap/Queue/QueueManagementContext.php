<?php

namespace Queue;

use Behat\Behat\Context\Context,
    Behat\Behat\Context\SnippetAcceptingContext,
    Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode,
    Behat\Behat\Tester\Exception\PendingException;

use NeoConnect\ServiceContainer\ServiceContainer;

/**
 * Defines application features from the specific context.
 */
class QueueManagementContext implements Context, SnippetAcceptingContext
{

    protected $config;

    protected $container;

    /**
     * @Given there is a default configuration
     */
    public function thereIsADefaultConfiguration()
    {
        $this->config = getcwd().'/features/templates/default_config.yml';
    }

    /**
     * @Given the application run
     */
    public function theApplicationRun()
    {
        $this->container = new ServiceContainer();
        $this->container->loadConfiguration($this->config)
            ->build();
    }

    /**
     * @When I ask the Queue Manager Service
     */
    public function iAskTheQueueManagerService()
    {
        expect($this->container->getQueueManager())->toHaveType('NeoConnect\Queue\QueueManager');
    }

    /**
     * @Then I should be able to access queues
     */
    public function iShouldBeAbleToAccessQueues()
    {
        $qm = $this->container->getQueueManager();
        expect($qm->getQueues())->toHaveCount(0);
    }

    /**
     * @When the Queue Manager receive a statement
     */
    public function theQueueManagerReceiveAStatement()
    {
        $query = 'MATCH (n) RETURN count(n)';
        $this->container->getKernel()->handleQuery($query);
    }

    /**
     * @Then he should add it to the :arg1 queue
     */
    public function heShouldAddItToTheQueue($arg1)
    {
        expect($this->container->getQueueManager()->getQueueForAlias('default')->getState())->toBe(1);
    }

    /**
     * @Given there is a multiple connections configuration
     */
    public function thereIsAMultipleConnectionsConfiguration()
    {
        throw new PendingException();
    }

    /**
     * @When the Queue Manager receive a statement for the :arg1 connection
     */
    public function theQueueManagerReceiveAStatementForTheConnection($arg1)
    {
        throw new PendingException();
    }
}
