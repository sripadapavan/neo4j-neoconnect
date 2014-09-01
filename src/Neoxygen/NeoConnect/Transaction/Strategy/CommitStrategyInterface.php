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

interface CommitStrategyInterface
{
    public function shouldBeFlushed(StatementStack $stack);
}