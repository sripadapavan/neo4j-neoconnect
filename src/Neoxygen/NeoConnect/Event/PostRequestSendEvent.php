<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace Neoxygen\NeoConnect\Event;

use Symfony\Component\EventDispatcher\Event;
use GuzzleHttp\Message\Response;

class PostRequestSendEvent extends Event
{
    protected $response;
    protected $startTime;
    protected $endTime;

    public function __construct(Response $response, $start = null, $end = null)
    {
        $this->response = $response;
        $this->startTime = $start;
        $this->endTime = $end;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function getStartTime()
    {
        return $this->startTime;
    }

    public function getEndTime()
    {
        return $this->endTime;
    }
}
