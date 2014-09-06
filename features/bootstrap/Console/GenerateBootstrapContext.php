<?php

namespace Console;

use BaseContext;
use Behat\Behat\Tester\Exception\PendingException;
use Neoxygen\NeoConnect\Generator\ConfigFileGenerator;
use Symfony\Component\Filesystem\Filesystem;

class GenerateBootstrapContext extends BaseContext
{
    /**
     * @Given There is a config file present
     */
    public function thereIsAConfigFilePresent()
    {
        $fs = new Filesystem();
        if (!$fs->exists(getcwd().'/neoconnect.yml')) {
            $generator = new ConfigFileGenerator($fs);
            $generator->generate();
        }
    }

    /**
     * @Given my configuration is the default config
     */
    public function myConfigurationIsTheDefaultConfig()
    {

    }

    /**
     * @Then I should have a bootstrap file generated
     */
    public function iShouldHaveABootstrapFileGenerated()
    {
        throw new PendingException();
    }

}
