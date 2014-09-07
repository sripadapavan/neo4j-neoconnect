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
use Behat\Behat\Context\SnippetAcceptingContext,
    Behat\Behat\Tester\Exception\PendingException;
use Symfony\Component\Filesystem\Filesystem;
use Neoxygen\NeoConnect\Generator\ConfigFileGenerator,
    Neoxygen\NeoConnect\ServiceContainer\ServiceContainer,
    Neoxygen\NeoConnect\Connection\ConnectionManager;

/**
 * Defines application features from the specific context.
 */
class ConnectionManagementContext implements Context, SnippetAcceptingContext
{
    protected $alias;
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
        $container->build();
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
        $container->build();
        $manager = $container->getConnectionManager();
        $connection = $manager->getDefaultConnection();
        if ($connection->getAlias() !== 'default') {
            throw new \Exception('Could not get the default connection');
        }
    }

    /**
     * @Given There is a multiple connections configuration
     */
    public function thereIsAMultipleConnectionsConfiguration()
    {
        $genConfig = getcwd().'/neoconnect.yml';
        $multipleTestConfig = getcwd().'/features/templates/multiple_connections_config.yml';
        $fs = new Filesystem();
        if ($fs->exists($genConfig)) {
            $fs->remove($genConfig);
        }
        $fs->copy($multipleTestConfig, $genConfig);
    }

    /**
     * @Then I can choose the :arg1 connection
     */
    public function iCanChooseTheConnection($alias)
    {
        $container = new ServiceContainer();
        $container->loadConfiguration(getcwd().'/neoconnect.yml');
        $container->loadServiceDefinitions();
        $container->build();
        $manager = $container->getConnectionManager();
        $conn = $manager->getConnection($alias);
    }

    /**
     * @When I ask a connection without specifying the alias
     */
    public function iAskAConnectionWithoutSpecifyingTheAlias()
    {
        $container = new ServiceContainer();
        $container->loadConfiguration(getcwd().'/neoconnect.yml');
        $container->loadServiceDefinitions();
        $container->build();
        $manager = $container->getConnectionManager();
        $conn = $manager->getConnection();
    }

    /**
     * @Then I should get the default connection
     */
    public function iShouldGetTheDefaultConnection()
    {
        $container = new ServiceContainer();
        $container->loadConfiguration(getcwd().'/neoconnect.yml');
        $container->loadServiceDefinitions();
        $container->build();
        $manager = $container->getConnectionManager();
        $conn = $manager->getConnection();
        expect($conn->getAlias())->toBe('default');
    }

    /**
     * @When I ask the :arg1 connection
     */
    public function iAskTheConnection($alias)
    {
        $this->alias = $alias;

    }

    /**
     * @Then I should have an invalid connection error
     */
    public function iShouldHaveAnInvalidConnectionError()
    {
        $container = new ServiceContainer();
        $container->loadConfiguration(getcwd().'/neoconnect.yml');
        $container->loadServiceDefinitions();
        $container->build();
        $manager = $container->getConnectionManager();
        expect($manager)->toThrow('\InvalidArgumentException')->during('getConnection', array($this->alias));
    }

    private function generateConfig()
    {
        $fs = new Filesystem();
        $fs->remove(getcwd().'/neoconnect.yml');
        $gen = new ConfigFileGenerator($fs);
        $gen->generate();
    }

}
