<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace Neoxygen\NeoConnect\EventSubscriber;

use Neoxygen\NeoConnect\Event\PreRequestCreateEvent,
    Neoxygen\NeoConnect\EventSubscriber\BaseEventSubscriber;

class BodyEncodingEventSubscriber extends BaseEventSubscriber
{

    public static function getSubscribedEvents()
    {
        return array(
            'pre.request_create' => array(
                array('onPreRequestCreate')
            )
        );
    }

    public function onPreRequestCreate(PreRequestCreateEvent $event)
    {
        if ($event->getRequest()->getMethod() === 'POST') {
            $body = $event->getRequest()->getBody();
            $event->getRequest()->setBody(json_encode($body));
        }

    }
}
