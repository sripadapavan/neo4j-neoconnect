<?php

namespace Console;

use BaseContext;
use Behat\Behat\Tester\Exception\PendingException;

class GenerateConfigContext extends BaseContext
{
    /**
     * @When I run the :arg1 command
     */
    public function iRunTheCommand($cmd)
    {
        $this->applicationTester = $this->createApplicationTester();
        $this->applicationTester->run('config:generate');
    }

    /**
     * @Then the config file should be generated
     */
    public function theConfigFileShouldBeGenerated()
    {
        $here = getcwd();
        if (!file_exists($here.'/neoconnect.yml')) {
            throw new \RuntimeException('Config file not present');
        }
    }

}
