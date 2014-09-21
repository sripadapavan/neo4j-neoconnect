<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace NeoConnect\HttpClient;

use GuzzleHttp\Client;
use NeoConnect\HttpClient\HttpClientInterface;

class GuzzleHttpClient implements HttpClientInterface
{
    private $client;

    private $defaultHeaders = array(
        'Accept' => 'application/json',
        'Content-Type' => 'application/json'
    );

    public function send($method, $url, $body = null, array $headers = array(), array $options = array())
    {
        if (null === $this->client) {
            $this->createClient();
        }

        $request = $this->client->createRequest($method, $url, $body = array());
        $iHeaders = array_merge($this->defaultHeaders, $headers);

        foreach ($iHeaders as $k => $v) {
            $request->setHeader($k, $v);
        }

        $response = $this->client->send($request);

        return $response->json();
    }

    private function createClient()
    {
        $this->client = new Client();
    }
}