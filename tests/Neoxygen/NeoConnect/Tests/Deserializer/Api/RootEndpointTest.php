<?php

namespace Neoxygen\NeoConnect\Tests\Deserializer\Api;

use Neoxygen\NeoConnect\Deserializer\Api\RootEndpoint;

class RootEndpointTest extends \PHPUnit_Framework_TestCase
{
    public function testItSetsAndGets()
    {
        $management = 'http://localhost:7474/db/management';
        $data = 'http://localhost:7474/db/data';

        $root = new RootEndpoint();
        $root->setData($data);
        $this->assertEquals($root->getData(), $data);

        $root->setManagement($management);
        $this->assertEquals($management, $root->getManagement());
    }
}
