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
use Neoxygen\NeoConnect\Generator\ConfigFileGenerator,
    Neoxygen\NeoConnect\ServiceContainer\ServiceContainer,
    Neoxygen\NeoConnect\Connection\ConnectionManager;

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
     * @When I access the connection manager
     */
    public function iAccessTheConfigurationManager()
    {
        $container = new ServiceContainer();
        $container->loadConfiguration(getcwd().'/neoconnect.yml');
        $container->loadServiceDefinitions();
        $container->setConnections();
        $manager = $container->getConnectionManager();
        if (!$manager instanceof ConnectionManager) {
            throw new \Exception('Can not access the connection manager');
        }
    }

    /**
     * @Then I should be able to get the default connection
     */
    public function iShouldBeAbleToGetTheDefaultConnection()
    {
        $container = new ServiceContainer();
        $container->loadConfiguration(getcwd().'/neoconnect.yml');
        $container->loadServiceDefinitions();
        $container->setConnections();
        $manager = $container->getConnectionManager();
        $connection = $manager->getDefaultConnection();
        if ($connection->getAlias() !== 'default') {
            throw new \Exception('Could not get the default connection');
        }
    }

    private function generateConfig()
    {
        $fs = new Filesystem();
        $fs->remove(getcwd().'/neoconnect.yml');
        $gen = new ConfigFileGenerator($fs);
        $gen->generate();
    }

}
