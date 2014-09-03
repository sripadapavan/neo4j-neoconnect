<?php

namespace Neoxygen\NeoConnect\Console;

use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Output\OutputInterface,
    Symfony\Component\Console\Question\ChoiceQuestion,
    Symfony\Component\Filesystem\Filesystem,
    Symfony\Component\Yaml\Yaml;

class ConfigurationCreateCommand extends Command
{
    protected function configure()
    {
        $this->setName('config:create')
            ->setDescription('Creates a default configuration for your project')
            ->addOption(
                'overwrite',
                'null',
                InputOption::VALUE_REQUIRED,
                'Do you want to overwrite exisiting file ?'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $cwd = getcwd();
        $cfname = 'neoconnect.yml';
        $fs = new Filesystem();

        $output->writeln('<comment>
Welcomme to the NeoConnect Console
**********************************
Generating Configuration File
</comment>');

        $default_config = array(
            'connection' => array(
                'scheme' => 'http',
                'host' => 'localhost',
                'port' => 7474
            ),
            'setup' => array(
                'project_source' => 'src',
            )
        );

        $yaml = Yaml::dump($default_config);
        if (!$fs->exists($cwd.'/neoconnect.yml')) {
            $fs->copy(__DIR__.'/templates/default_config.yml.dist', $cwd.'/neoconnect.yml');
            $output->writeln('<info>Created new config file "neoconnect_config.yml" in "'.$cwd.'"</info>');
        } else {
            $output->writeln('<info>Existing configuration file found !</info>');
            $helper = $this->getHelper('question');
            $question = new ChoiceQuestion(
                '<question>Do you want to overwrite existing "neoconnect.yml" file ?</question> :  ',
                array('y' => 'Yes', 'n' => 'No'),
                'n'
            );
            $question->setErrorMessage('Choice "%s" is not valid, choose between Y or N');
            $question->setNormalizer(function ($ov) use($output){
                $x = strtolower($ov);
                $m = str_replace(array('yes','no'), array('y','n'), $ov);
                return $m;
            });

            if ($helper->ask($input, $output, $question) == 'Yes') {
                $fs->remove($cwd.'/neconnect.yml');
                $output->writeln('<info>Existing configuration file removed</info>');
                $fs->touch($cwd.'/neoconnect.yml');
                $fs->dumpFile($cwd.'/neoconnect.yml', $yaml);
                $output->writeln('<info>Created new config file "neoconnect.yml" in "'.$cwd.'"</info>');
            }
        }
    }
}