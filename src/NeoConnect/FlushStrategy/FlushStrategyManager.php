<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace NeoConnect\FlushStrategy;

use NeoConnect\NeoEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use NeoConnect\FlushStrategy\FlushStrategyInterface,
    NeoConnect\Exception\StrategyException,
    NeoConnect\Connection\Connection,
    NeoConnect\Event\NeoKernelEvents\applyStrategyForQueueEvent;

class FlushStrategyManager implements EventSubscriberInterface
{
    private $strategies;
    private $defaultStrategy;
    private $applyFlushStrategyEvent;

    public function __construct()
    {
        $this->strategies = array();
    }

    public static function getSubscribedEvents()
    {
        return array(
            NeoEvents::NEO_KERNEL_FLUSH_STRATEGY => array(
                'applyFlushStrategy'
            )
        );
    }

    public function registerStrategyService($strategyAlias, FlushStrategyInterface $strategy)
    {
        if (array_key_exists($strategyAlias, $this->strategies)) {
            throw new StrategyException(sprintf('The strategy "%s" is already registered', $strategyAlias));
        }
        $this->strategies[$strategyAlias] = $strategy;
    }

    public function getStrategy($strategyAlias)
    {
        return $this->strategies[$strategyAlias];
    }

    public function getDefaultStrategy()
    {
        return $this->strategies[$this->defaultStrategy];
    }

    public function setDefaultStrategy($strategyAlias)
    {
        if (!array_key_exists($strategyAlias, $this->strategies)) {
            throw new StrategyException(sprintf('The strategy "%s" is not registered', $strategyAlias));
        }
        $this->defaultStrategy = $strategyAlias;
    }

    public function applyFlushStrategy(applyStrategyForQueueEvent $event)
    {
        $this->applyFlushStrategyEvent = $event;
        $strategy = $this->findStrategy($event->getConnection());
        $decision = $strategy->performFlushDecision($event->getQueue()) ? true : false;

        $event->setFlushDecision($decision);
    }

    public function getApplyFlushStrategyEvent()
    {
        return $this->applyFlushStrategyEvent;
    }

    public function findStrategy(Connection $connection)
    {
        return $this->getStrategy($connection->getFlushStrategy());
    }
}
