<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace Neoxygen\NeoConnect\EventListener;

use Neoxygen\NeoConnect\Event\PreRequestSendEvent;

class DefaultHeadersListener
{
    public function onPreRequestSend(PreRequestSendEvent $event)
    {
        $request = $event->getRequest();
        $request->addHeader('Accept', 'application/json');
        if ('POST' === $request->getMethod()) {
            $request->addHeader('Content-Type', 'application/json');
        }

        return $event;
    }
}
