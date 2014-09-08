<?php

namespace Statement;

use Behat\Behat\Context\Context,
    Behat\Behat\Context\SnippetAcceptingContext,
    Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode,
    Behat\Behat\Tester\Exception\PendingException;

use NeoConnect\Statement\StatementManager;


/**
 * Defines application features from the specific context.
 */
class StatementManagementContext implements Context, SnippetAcceptingContext
{
    protected $query;
    protected $parameters;
    protected $statement;

    /**
     * @Given I send a simple match query
     */
    public function iSendASimpleMatchQuery()
    {
        $this->query = 'MATCH (n) RETURN count(n)';
    }

    /**
     * @Given my query does not contain parameters
     */
    public function myQueryDoesNotContainParameters()
    {
        $this->parameters = array();
    }

    /**
     * @Then it should create a Statement object
     */
    public function itShouldCreateAStatementObject()
    {
        $manager = new StatementManager();
        $this->statement = $manager->createStatement($this->query, $this->parameters);
    }

    /**
     * @Then the Statement should not contain parameters
     */
    public function theStatementShouldNotContainParameters()
    {
        expect($this->statement->hasParameters())->toBe(false);
    }

    /**
     * @Given I provide the following parameters:
     */
    public function iProvideTheFollowingParameters(TableNode $table)
    {
        $params = array();
        foreach ($table->getHash() as $k => $param) {
            $params[$param['key']] = $param['value'];
        }
        $this->parameters = $params;
    }

    /**
     * @When I ask the StatementManager to create the statement
     */
    public function iAskTheStatementmanagerToCreateTheStatement()
    {
        $manager = new StatementManager();
        $this->statement = $manager->createStatement($this->query, $this->parameters);
    }

    /**
     * @Then the Statement should contain parameters
     */
    public function theStatementShouldContainParameters()
    {
        expect($this->statement->hasParameters())->toBe(true);
    }
}
