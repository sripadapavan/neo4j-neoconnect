<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace Neoxygen\NeoConnect\EventSubscriber;

use Neoxygen\NeoConnect\Event\PreQueryAddedToStackEvent,
    Neoxygen\NeoConnect\Event\PreRequestSendEvent,
    Neoxygen\NeoConnect\Event\PostRequestSendEvent,
    Neoxygen\NeoConnect\Event\GenericLoggingEvent,
    Neoxygen\NeoConnect\Logger\Logger,
    Neoxygen\NeoConnect\EventSubscriber\BaseEventSubscriber;

class LoggingEventSubscriber extends BaseEventSubscriber
{
    protected $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public static function getSubscribedEvents()
    {
        return array(
            'pre.query_add_to_stack' => array(
                array('onPreQueryAddToStack')
            ),
            'pre.request_send' => array(
                array('onPreRequestSend')
            ),
            'post.request_send' => array(
                array('onPostRequestSend')
            ),
            'generic.logging' => array(
                array('onGenericLogging')
            )
        );
    }

    public function onPreQueryAddToStack(PreQueryAddedToStackEvent $event)
    {
        $q = $event->getStatement()->getStatement();
        $p = $event->getStatement()->getParameters();
        $this->logger->debug('Query added to stack', array('query' => $q, 'parameters' => $p));

        return $event;
    }

    public function onPreRequestSend(PreRequestSendEvent $event)
    {
        $this->start = microtime(true);
    }

    public function onPostRequestSend(PostRequestSendEvent $event)
    {
        $this->logger->debug($this->getLogDiff($event->getStartTime(), $event->getEndTime()));

    }

    public function getLogDiff($start, $end)
    {
        $diff = $end - $start;

        return 'Request sent in '.$diff.' seconds';
    }

    public function onGenericLogging(GenericLoggingEvent $event)
    {
        $this->logger->log($event->getLevel(), $event->getMessage());
    }
}
