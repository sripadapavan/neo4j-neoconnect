<?php

namespace Neoxygen\NeoConnect\Console;

use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Output\OutputInterface;
use Neoxygen\NeoConnect\Configuration\ConfigValidator;

class ConfigCheckCommand extends BaseCommand
{
    protected function configure()
    {
        $this->setName('config:check')
            ->setDescription('Checks the user configuration against the ConfigDefinition');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $validator = new ConfigValidator();
        $file = getcwd().'/neoconnect.yml';

        try {
            $validator->validateConfiguration($file);
            $output->writeln('<info>The configuration is valid</info>');
        } catch (\InvalidArgumentException $e) {
            $output->writeln('<error>The configuration is invalid !'.PHP_EOL.$e->getMessage());
        }
    }
}