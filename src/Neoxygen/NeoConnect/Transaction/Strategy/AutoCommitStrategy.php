<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace Neoxygen\NeoConnect\Transaction\Strategy;

use Neoxygen\NeoConnect\Statement\StatementStack;

class AutoCommitStrategy implements CommitStrategyInterface
{
    public function shouldBeFlushed(StatementStack $stack)
    {
        if (0 !== $stack->count()) {
            return true;
        }
    }

    public function __toString()
    {
        return 'Auto';
    }
}
