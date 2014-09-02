<?php

namespace Neoxygen\NeoConnect\Tests\HttpClient;

use Neoxygen\NeoConnect\HttpClient\Request;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    public function testDefaultsAreMutable()
    {
        $defaults = array('timeout' => 5);
        $request = new Request('POST', 'http://www.example.com', 'my super body', $defaults);
        $this->assertTrue(array_key_exists('timeout', $request->getDefaults()));
    }
}
