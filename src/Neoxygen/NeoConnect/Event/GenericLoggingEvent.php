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

class GenericLoggingEvent extends Event
{
    protected $message;
    protected $level;

    public function __construct($message, $level = 'debug')
    {
        $this->message = $message;
        $this->level = strtolower($level);
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getLevel()
    {
        return $this->level;
    }
}
