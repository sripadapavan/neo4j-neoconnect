<?php

namespace spec;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Filesystem\Filesystem;

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

    public function createConfig()
    {
        $cwd = getcwd();
        $fs = new Filesystem();
        if ($fs->exists($cwd.'/neoconnect.yml')) {
            $fs->remove($cwd.'/neoconnect.yml');
        }
        $fs->copy($cwd.'/features/templates/default_config.yml', $cwd.'/neoconnect.yml');

        return $cwd.'/neoconnect.yml';
    }
}