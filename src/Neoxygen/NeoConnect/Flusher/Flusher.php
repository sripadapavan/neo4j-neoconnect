<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace Neoxygen\NeoConnect\Flusher;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Neoxygen\NeoConnect\Event\QueueShouldNotBeFlushedEvent;

class Flusher implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            'queue.should_not_be_flushed' => array(
                array('onQueueShouldNotBeFlushed')
            )
        );
    }

    public function onQueueShouldNotBeFlushed(QueueShouldNotBeFlushedEvent $event)
    {
        //var_dump($event);
    }
}