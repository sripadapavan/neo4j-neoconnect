<?php

namespace ServiceContainer;

use Behat\Behat\Context\Context,
    Behat\Behat\Context\SnippetAcceptingContext,
    Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode,
    Behat\Behat\Tester\Exception\PendingException;
use NeoConnect\ServiceContainer\ServiceContainer;
/**
 * Defines application features from the specific context.
 */
class ServiceContainerContext implements Context, SnippetAcceptingContext
{

    protected $config;

    protected $container;

    /**
     * @Given there is a default configuration
     */
    public function thereIsADefaultConfiguration()
    {
        $this->config = getcwd().'/features/templates/default_config.yml';
    }

    /**
     * @When the application run
     */
    public function theApplicationRun()
    {
        $this->container = new ServiceContainer();
            $this->container->loadConfiguration($this->config)
            ->build();
    }

    /**
     * @Then it should create a Service Container
     */
    public function itShouldCreateAServiceContainer()
    {
        expect($this->container)->toHaveType('NeoConnect\ServiceContainer\ServiceContainer');
    }

    /**
     * @Then I should have access to the connection manager
     */
    public function iShouldHaveAccessToTheConnectionManager()
    {
        expect($this->container->getConnectionManager())->toHaveType('NeoConnect\Connection\ConnectionManager');
    }

    /**
     * @Then I should have access to the default connection
     */
    public function iShouldHaveAccessToTheDefaultConnection()
    {
        expect($this->container->getConnectionManager()->getDefaultConnection()->getAlias())->toBe('default');
    }

    /**
     * @Then the connection parameters should be:
     */
    public function theConnectionParametersShouldBe(TableNode $table)
    {
        $hash = $table->getHash();
        $scheme = $hash[0]['value'];
        $host = $hash[1]['value'];
        $port = (int) $hash[2]['value'];
        expect($this->container->getConnectionManager()->getDefaultConnection()->getScheme())->toBe($scheme);
        expect($this->container->getConnectionManager()->getDefaultConnection()->getHost())->toBe($host);
        expect($this->container->getConnectionManager()->getDefaultConnection()->getPort())->toBe($port);
    }

    /**
     * @Then the flush strategy should be :arg1
     */
    public function theFlushStrategyShouldBe($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then the authentication mode should be disabled
     */
    public function theAuthenticationModeShouldBeDisabled()
    {
        throw new PendingException();
    }

    /**
     * @Then there should be a :arg1 service
     */
    public function thereShouldBeAService($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then there should be a :arg1 service alias
     */
    public function thereShouldBeAServiceAlias($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then there should be an event dispatcher available
     */
    public function thereShouldBeAnEventDispatcherAvailable()
    {
        throw new PendingException();
    }
}
