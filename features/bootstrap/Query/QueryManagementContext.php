<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */
namespace Query;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext,
    Behat\Behat\Tester\Exception\PendingException;
use Neoxygen\NeoConnect\Generator\ConfigFileGenerator,
    Neoxygen\NeoConnect\ServiceContainer\ServiceContainer,
    Neoxygen\NeoConnect\Connection\ConnectionManager;

/**
 * Defines application features from the specific context.
 */
class QueryManagementContext implements Context, SnippetAcceptingContext
{

    /**
     * @Given The application is bootstrapped with default config
     */
    public function theApplicationIsBootstrappedWithDefaultConfig()
    {
        throw new PendingException();
    }

    /**
     * @When I send :arg1 basic match queries
     */
    public function iSendBasicMatchQueries($arg1)
    {
        throw new PendingException();
    }

    /**
     * @When I commit
     */
    public function iCommit()
    {
        throw new PendingException();
    }

    /**
     * @Then I should have :arg1 query results in json format
     */
    public function iShouldHaveQueryResultsInJsonFormat($arg1)
    {
        throw new PendingException();
    }
}
