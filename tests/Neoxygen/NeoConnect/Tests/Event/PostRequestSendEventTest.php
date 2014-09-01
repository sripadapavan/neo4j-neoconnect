<?php

namespace Neoxygen\NeoConnect\Tests\Event;

use GuzzleHttp\Message\Response;
use Neoxygen\NeoConnect\Event\PostRequestSendEvent;

class PostRequestSendEventTest extends \PHPUnit_Framework_TestCase
{
    public function testItHandleEvent()
    {
        $response = new Response(200, array(), null);
        $event = new PostRequestSendEvent($response);
        $this->assertEquals($response, $event->getResponse());

    }
}
