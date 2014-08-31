<?php

namespace Neoxygen\NeoConnect\Tests;

use Neoxygen\NeoConnect\ConnectionBuilder;

class ConnectionBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateFactory()
    {
        $create = ConnectionBuilder::create();
        $this->assertInstanceOf('Neoxygen\NeoConnect\ConnectionBuilder', $create);
    }

    public function testCreateInstantiateHttpClient()
    {
        $create = ConnectionBuilder::create();
        $this->assertInstanceOf('Symfony\Component\DependencyInjection\Container', $create->getContainer());
    }

    public function testParameterBagIsNotResolvedWhenCreate()
    {
        $create = ConnectionBuilder::create();
        $this->assertFalse($create->getContainer()->getParameterBag()->isResolved());
    }
}