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
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Output\OutputInterface;

use Neoxygen\NeoConnect\ConnectionBuilder;

class ConfigurationCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('config:dump')
            ->setDescription('Dump the configuration');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $connection = ConnectionBuilder::create()->build();

        $neo4jVersion = $connection->getNeo4jVersion();
        $output->writeln('<info>NeoConnect Console v0.4-dev | Neo4j Version : ' . $neo4jVersion . '</info>');

        $params = $connection->getParameters();
        $table = $this->getHelper('table');
        $table->setHeaders(array('Parameter Name', 'Value'));
        foreach ($params->all() as $k => $v) {
            $table->addRow(
                    array($k, $v)
                );
        }

        $table->render($output);
    }
}
