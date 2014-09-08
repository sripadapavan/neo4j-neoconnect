<?php

namespace spec;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NeoBaseSpec extends ObjectBehavior
{
    public function getMatchers()
    {
        return [
            'haveCountValues' => function($subject, $key) {
                return array_count_values($subject) === $key;
            },
        ];
    }
}