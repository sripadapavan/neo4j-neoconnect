<?php

namespace Console;

use BaseContext;
use Behat\Behat\Tester\Exception\PendingException;

class GenerateBootstrapContext extends BaseContext
{
    /**
     * @Given There is a config file present
     */
    public function thereIsAConfigFilePresent()
    {
        throw new PendingException();
    }

    /**
     * @Given my configuration is the default config
     */
    public function myConfigurationIsTheDefaultConfig()
    {
        throw new PendingException();
    }

    /**
     * @Then I should have a bootstrap file generated
     */
    public function iShouldHaveABootstrapFileGenerated()
    {
        throw new PendingException();
    }

}