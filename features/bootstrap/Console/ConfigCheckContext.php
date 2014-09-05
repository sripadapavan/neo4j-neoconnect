<?php

namespace Console;

use BaseContext;
use Behat\Behat\Tester\Exception\PendingException;
use Symfony\Component\Yaml\Yaml;

class ConfigCheckContext extends BaseContext
{
    /**
     * @When I check the config with the cli
     */
    public function iRunTheConfigCheckCommand()
    {
        $this->applicationTester = $this->createApplicationTester();
        $this->applicationTester->run('config:check');
    }

    /**
     * @Then there should be no errors
     */
    public function thereShouldBeNoErrors()
    {
        $this->applicationTester = $this->createApplicationTester();
        $this->applicationTester->run('config:check');
        $this->iShouldSee('The configuration is valid');
    }

    /**
     * @Given my configuration is invalid
     */
    public function myConfigurationIsInvalid()
    {
        $config = Yaml::parse(getcwd().'/neoconnect.yml');
        $con = $config['neoconnect']['connection'];
        unset($config['neoconnect']['connection']);
        $config['connectionssss'] = $con;
        Yaml::dump(getcwd().'/neoconnect.yml', $config);
    }

    /**
     * @Then I should see an error message
     */
    public function iShouldSeeAnErrorMessage()
    {
        $this->applicationTester = $this->createApplicationTester();
        $this->applicationTester->run('config:check');
        $this->iShouldSee('is invalid');
    }

}