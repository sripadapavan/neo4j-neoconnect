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
    Neoxygen\NeoConnect\NeoConnectEvents;

class HttpClient implements HttpClientInterface
{
    protected $baseUrl;
    protected $client;
    protected $eventDispatcher;

    public function __construct($scheme, $host, $port, EventDispatcherInterface $eventDispatcher)
    {
        $this->baseUrl = $scheme . '://' . $host . ':' . $port;
        $this->eventDispatcher = $eventDispatcher;
        $this->client = new Client();
    }

    public function send($method, $url = null, array $defaults = array(), $body = null)
    {
        $uri = null !== $url ? (string) $url : $this->baseUrl;
        $request = $this->client->createRequest($method, $uri, $defaults, $body);

        $event = new PreRequestSendEvent($request);

        $this->eventDispatcher->dispatch(NeoConnectEvents::PRE_REQUEST_SEND, $event);

        $response = $this->client->send($request);

        $postSendEvent = new PostRequestSendEvent($response);

        $this->eventDispatcher->dispatch(NeoConnectEvents::POST_REQUEST_SEND, $postSendEvent);

        return (string) $response->getBody();

    }

}
