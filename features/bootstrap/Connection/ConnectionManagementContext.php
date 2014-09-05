<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */
namespace Connection;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;
use Symfony\Component\Filesystem\Filesystem;
use Neoxygen\NeoConnect\Generator\ConfigFileGenerator;

/**
 * Defines application features from the specific context.
 */
class ConnectionManagementContext implements Context, SnippetAcceptingContext
{
    /**
     * @Given There is a default config file present
     */
    public function thereIsAConfigFilePresent()
    {
        $this->generateConfig();
    }

    /**
     * @When I access the configuration manager
     */
    public function iAccessTheConfigurationManager()
    {
        throw new PendingException();
    }

    /**
     * @Then I should be able to get the default connection
     */
    public function iShouldBeAbleToGetTheDefaultConnection()
    {
        throw new PendingException();
    }

    private function generateConfig()
    {
        $fs = new Filesystem();
        $fs->remove(getcwd().'/neoconnect.yml');
        $gen = new ConfigFileGenerator($fs);
        $gen->generate();
    }

}
