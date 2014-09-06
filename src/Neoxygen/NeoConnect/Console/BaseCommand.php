<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace Neoxygen\NeoConnect\Console;

use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Output\OutputInterface;
use Neoxygen\NeoConnect\Connection;

class BaseCommand extends Command
{
    const VERSION = Connection::VERSION;

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $v = Connection::VERSION;
        $output->writeln('
<comment>Welcome to the NeoConnect Console - v'.$v.'
**********************************************
</comment>');
    }
}
