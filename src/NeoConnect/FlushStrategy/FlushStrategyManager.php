<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace NeoConnect\FlushStrategy;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use NeoConnect\FlushStrategy\FlushStrategyInterface,
    NeoConnect\Exception\StrategyException;

class FlushStrategyManager implements EventSubscriberInterface
{
    private $strategies;
    private $defaultStrategy;

    public function __construct()
    {
        $this->strategies = array();
    }

    public static function getSubscribedEvents()
    {
        return array();
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
}
