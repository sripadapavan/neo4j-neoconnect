<?php

namespace Config;

use Behat\Behat\Context\Context,
    Behat\Behat\Context\SnippetAcceptingContext,
    Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode,
    Behat\Behat\Tester\Exception\PendingException;

/**
 * Defines application features from the specific context.
 */
class ConfigurationContext implements Context, SnippetAcceptingContext
{

    /**
     * @Given there is a :arg1 default config file present at the root of the project
     */
    public function thereIsADefaultConfigFilePresentAtTheRootOfTheProject($arg1)
    {
        throw new PendingException();
    }

    /**
     * @When I load and parse the configuration
     */
    public function iLoadAndParseTheConfiguration()
    {
        throw new PendingException();
    }

    /**
     * @Then I should have an array equal to the default configuration
     */
    public function iShouldHaveAnArrayEqualToTheDefaultConfiguration()
    {
        throw new PendingException();
    }

    /**
     * @When I validate it
     */
    public function iValidateIt()
    {
        throw new PendingException();
    }

    /**
     * @Then I should have a valid configuration
     */
    public function iShouldHaveAValidConfiguration()
    {
        throw new PendingException();
    }

    /**
     * @When I replace the :arg1 key by the :arg2 key
     */
    public function iReplaceTheKeyByTheKey($arg1, $arg2)
    {
        throw new PendingException();
    }

    /**
     * @Then I should have an invalid configuration error
     */
    public function iShouldHaveAnInvalidConfigurationError()
    {
        throw new PendingException();
    }
}
