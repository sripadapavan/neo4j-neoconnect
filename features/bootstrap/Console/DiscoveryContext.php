<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace Console;

use BaseContext;
use Behat\Behat\Tester\Exception\PendingException;

class DiscoveryContext extends BaseContext
{

    /**
     * @Given I am on the root directory of my project
     */
    public function iAmOnTheRootDirectoryOfMyProject()
    {
        $cwd = getcwd();
        if (!file_exists('behat.yml')) {
            return false;
        }
        $this->cwd = $cwd;

        return true;
    }

    /**
     * @When I execute the neoconnect command
     */
    public function iExecuteTheNeoconnectCommand()
    {
        $this->applicationTester = $this->createApplicationTester();
    }

    /**
     * @Then I should be presented the Console help message
     * @Then I should see the console prompt me hello
     */
    public function iShouldSeeTheConsolePromptMeHello()
    {
        $this->applicationTester = $this->createApplicationTester();
        $this->applicationTester->run('');

        if (!$this->iShouldSee('Usage:')) {
            throw new \RuntimeException('The Console did not output the help message'.PHP_EOL.
                $this->applicationTester->getDisplay());
        }
    }

    /**
     * @Given There is no config file present
     */
    public function thereIsNoConfigFilePresent()
    {
        $cwd = $this->cwd;
        if (file_exists($cwd.'/neoconnect.yml')) {
            @unlink($cwd.'/neoconnect.yml');
        }
    }

    /**
     * @When I excecute the :arg1 command
     */
    public function iExcecuteTheCommand($arg1)
    {
        $this->applicationTester = $this->createApplicationTester();

        $code = $this->applicationTester->run('config:generate');
        if (0 !== $code) {
            throw new \RuntimeException(sprintf('Console command "%s" failed'.PHP_EOL.
                $this->applicationTester->getDisplay(), $arg1));
        }
    }

    /**
     * @Then It should generate a config file for me
     */
    public function itShouldGenerateAConfigFileForMe()
    {
        throw new PendingException();
    }

    /**
     * @Then this file should be the same than the template config file
     */
    public function thisFileShouldBeTheSameThanTheTemplateConfigFile()
    {
        throw new PendingException();
    }

}
