<?php

namespace Neoxygen\NeoConnect\Tests\DependencyInjection;

use Neoxygen\NeoConnect\DependencyInjection\NeoConnectExtension;

class NeoConnectExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testXsdValdiationPath()
    {
        $root = realpath(__DIR__.'/../../../../../src/Neoxygen/NeoConnect/Resources/config/');
        $ext = new NeoConnectExtension();
        $this->assertEquals($root, realpath($ext->getXsdValidationBasePath()));
    }
}
