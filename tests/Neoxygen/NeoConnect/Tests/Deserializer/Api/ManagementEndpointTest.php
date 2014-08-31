<?php

namespace Neoxygen\NeoConnect\Tests\Deserializer\Api;

use Neoxygen\NeoConnect\Deserializer\Api\ManagementEndpoint;

class ManagementEndpointTest extends \PHPUnit_Framework_TestCase
{
    public function testItSetsAndGets()
    {
        $services = array(
            'jmx' => 'http://localhost:7474/db/management/services/jmx'
        );
        $management = new ManagementEndpoint();
        $management->setServices($services);
        $this->assertEquals($management->getServices(), $services);
    }
}