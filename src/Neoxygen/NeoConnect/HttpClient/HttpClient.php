<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace Neoxygen\NeoConnect\HttpClient;

use GuzzleHttp\Client;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Neoxygen\NeoConnect\Event\PreRequestSendEvent,
    Neoxygen\NeoConnect\Event\PostRequestSendEvent,
    Neoxygen\NeoConnect\Event\PreRequestCreateEvent,
    Neoxygen\NeoConnect\NeoConnectEvents,
    Neoxygen\NeoConnect\HttpClient\Request;

class HttpClient implements HttpClientInterface
{
    protected $baseUrl;
    protected $client;
    protected $eventDispatcher;

    public function send($method, $url = null, $body = null, array $defaults = array())
    {
        $uri = null !== $url ? (string) $url : $this->baseUrl;

        $request = new Request($method, $uri, $body, $defaults);

        $prcEvent = new PreRequestCreateEvent($request);
        $this->eventDispatcher->dispatch(NeoConnectEvents::PRE_REQUEST_CREATE, $prcEvent);

        $request = $this->client->createRequest(
            $request->getMethod(),
            $request->getUrl(),
            [
                'body' => $request->getBody(),
            ]
        );

        $event = new PreRequestSendEvent($request);

        $this->eventDispatcher->dispatch(NeoConnectEvents::PRE_REQUEST_SEND, $event);
        $start = microtime(true);
        $response = $this->client->send($request);
        $end = microtime(true);
        $postSendEvent = new PostRequestSendEvent($response, $start, $end);
        $this->eventDispatcher->dispatch(NeoConnectEvents::POST_REQUEST_SEND, $postSendEvent);

        return (string) $response->getBody();

    }

}
