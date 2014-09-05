<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Console\ApplicationTester;
use Symfony\Component\Console\Application;
use Neoxygen\NeoConnect\Console\ConfigurationGenerationCommand,
    Neoxygen\NeoConnect\Console\ConfigCheckCommand;

/**
 * Defines application features from the specific context.
 */
abstract class BaseContext implements Context, SnippetAcceptingContext
{

    protected $applicationTester;
    protected $cwd;

    protected function createApplicationTester()
    {
        $application = new Application();
        $c = new ConfigurationGenerationCommand();
        $check = new ConfigCheckCommand();
        $application->setName('NeoConnect Console');
        $application->setVersion('0.5-dev');
        $application->setAutoExit(false);
        $application->add($c);
        $application->add($check);

        return new ApplicationTester($application);
    }

    protected function iShouldSee($string)
    {
        return preg_match('#'.$string.'#', $this->applicationTester->getDisplay());
    }
}
