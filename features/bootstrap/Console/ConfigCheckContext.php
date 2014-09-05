<?php

namespace Console;

use BaseContext;
use Behat\Behat\Tester\Exception\PendingException;

class ConfigCheckContext extends BaseContext
{
    /**
     * @Then there should be no errors
     */
    public function thereShouldBeNoErrors()
    {
        throw new PendingException();
    }

    /**
     * @Given my configuration is invalid
     */
    public function myConfigurationIsInvalid()
    {
        throw new PendingException();
    }

    /**
     * @Then I should see an error message
     */
    public function iShouldSeeAnErrorMessage()
    {
        throw new PendingException();
    }

}