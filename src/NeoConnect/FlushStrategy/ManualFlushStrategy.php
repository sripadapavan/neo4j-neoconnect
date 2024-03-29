<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace NeoConnect\FlushStrategy;

use NeoConnect\FlushStrategy\AbstractFlushStrategy,
    NeoConnect\NeoEvents,
    NeoConnect\Queue\Queue;

class ManualFlushStrategy extends AbstractFlushStrategy
{

    public function performFlushDecision(Queue $queue)
    {
        return false;
    }
}
