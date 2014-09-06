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
use Neoxygen\NeoConnect\Query\Queue;

class QueueShouldNotBeFlushedEvent extends Event
{
    protected $queue;

    public function __construct(Queue $queue)
    {
        $this->queue = $queue;
    }

    public function getQueue()
    {
        return $this->queue;
    }
}
