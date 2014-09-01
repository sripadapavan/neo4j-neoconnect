<?php

namespace Neoxygen\NeoConnect\Tests\EventListener;

use GuzzleHttp\Client;
use Neoxygen\NeoConnect\Event\PreRequestSendEvent;
use Neoxygen\NeoConnect\EventListener\DefaultHeadersListener;

class DefaultHeaderListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testItAddsDefaultsHeadersToRequest()
    {
        $client = new Client();
        $request = $client->createRequest('GET', 'http://localhost:7474');
        $listener = new DefaultHeadersListener();
        $event = new PreRequestSendEvent($request);

        $this->assertFalse($event->getRequest()->getHeader('Content-Type') == 'application/json');

        $returnedEvent = $listener->onPreRequestSend($event);

        $this->assertTrue($returnedEvent->getRequest()->getHeader('Accept') == 'application/json');

        $req = $client->createRequest('POST', 'http://localhost:7474', ['body' => 'hello']);
        $event = new PreRequestSendEvent($req);
        $this->assertFalse($event->getRequest()->getHeader('Content-Type') == 'application/json');
        $modEvent = $listener->onPreRequestSend($event);
        $this->assertTrue($modEvent->getRequest()->getHeader('Content-Type') == 'application/json');

    }
}
