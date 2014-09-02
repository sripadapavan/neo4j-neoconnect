<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace Neoxygen\NeoConnect\Transaction\Strategy;

use Neoxygen\NeoConnect\Statement\StatementStack,
    Neoxygen\NeoConnect\EventDispatcher\EventDispatcher,
    Neoxygen\NeoConnect\Event\GenericLoggingEvent,
    Neoxygen\NeoConnect\NeoConnectEvents;

class StackCommitStrategy implements CommitStrategyInterface
{
    protected $dispatcher;

    public function __construct(EventDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function shouldBeFlushed(StatementStack $stack)
    {
        foreach ($stack->getStatements() as $statement) {
            if ($statement->hasFlushTrigger()) {
                $this->log('FlushTrigger found');

                return true;
            }
        }
        $this->log('No FlushTrigger found');

        return false;
    }

    public function log($message, $level = 'debug')
    {
        $event = new GenericLoggingEvent($message, $level);

        return $this->dispatcher->dispatch(NeoConnectEvents::GENERIC_LOGGING, $event);
    }

    public function __toString()
    {
        return 'Stack';
    }
}
