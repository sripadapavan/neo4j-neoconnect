<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace Neoxygen\NeoConnect\Event;

use Symfony\Component\EventDispatcher\Event;
use Neoxygen\NeoConnect\Statement\Statement;

class PreQueryAddedToStackEvent extends Event
{
    protected $statement;

    public function __construct(Statement $statement)
    {
        $this->statement = $statement;
    }

    public function getStatement()
    {
        return $this->statement;
    }
}
