<?php

namespace Neoxygen\NeoConnect\Console;

use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Output\OutputInterface,
    Symfony\Component\Console\Question\ChoiceQuestion,
    Symfony\Component\Filesystem\Filesystem;
use Neoxygen\NeoConnect\Generator\ConfigFileGenerator;

class ConfigurationGenerationCommand extends BaseCommand
{
    protected function configure()
    {
        $this->setName('config:generate')
            ->setDescription('Generates a default configuration for your project');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new Filesystem();
        $generator = new ConfigFileGenerator($io);

        if (!$generator->generate()) {
            $output->writeln('<error>The configuration file could not be created</error>');
        } else {
            $output->writeln('<info>Configuration file successfully created</info>');
        }
    }
}