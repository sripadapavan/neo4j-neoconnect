<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace Neoxygen\NeoConnect\Configuration;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

class Definition implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('neoconnect');

        $supportedCommitStrategies = array('auto', 'stack', 'custom');
        $supportedLoggerTypes = array('stream'); // other supports in the roadmap

        $rootNode->children() // Children
            ->arrayNode('connection') //Connection
            ->addDefaultsIfNotSet()
                ->children()  //Conenction CH
                    ->scalarNode('class')->defaultValue('Neoxygen\NeoConnect\HttpClient\HttpClient')->end()
                    ->scalarNode('scheme')->defaultValue('http')->end()
                    ->scalarNode('host')->defaultValue('localhost')->end()
                    ->integerNode('port')->defaultValue('7474')->end()
                ->end() // End Connection CH
                ->end() // End Connection

            ->arrayNode('transaction') // TRANSACTION
            ->addDefaultsIfNotSet()
                ->children()  // TRANSACTION CHILDREN

                    ->scalarNode('mode')->defaultValue('auto')->end()

                    ->arrayNode('commit_strategy') // COMMIT STRAT
                        ->addDefaultsIfNotSet()
                            ->children() // COMMIT STRAT CH
                                ->scalarNode('strategy')->defaultValue('auto')
                                    ->validate()
                                    ->ifNotInArray($supportedCommitStrategies)
                                    ->thenInvalid('The commit strategy %s is not supported. Please choose one of
                                    '.json_encode($supportedCommitStrategies))
                                    ->end() // END VALIDATION STRATEGY
                                ->end()// END STRATEGY

                                ->scalarNode('class')->end()
                                ->integerNode('stack_flush_limit')->end()
                            ->end() // END COMMIT STRATEGy CH
                    ->end() // END COMMIT STRATEGY
                ->end() // END TRANSACTION CHILDREN
            ->validate()
            ->ifTrue(function ($v) {return $v['commit_strategy']['strategy'] === 'custom'
            && empty($v['commit_strategy']['class']);})
            ->thenInvalid("You need to specify your custom commit strategy class")
            ->end()

            ->end() // END TRANSACTION



                ->arrayNode('logger') // LOGGERS
                    ->prototype('array')
                    ->children()
                        ->scalarNode('type')
                            ->validate()
                            ->ifNotInArray($supportedLoggerTypes)
                            ->thenInvalid('The logging type %s is not supported. Only "stream" is currently supported')
                            ->end() // END VALIDATION LOG TYPE
                        ->end()
                        ->scalarNode('path')->end()
                        ->scalarNode('level')->isRequired()->cannotBeEmpty()->end()
                    ->end() // END CHILDREN LOGGERS
                    ->validate()
                    ->ifTrue(function ($v) { return $v['type'] === 'stream' && empty($v['path']);})
                    ->thenInvalid('You need to specify a path for your logfile when using the "stream" logging type')
                    ->end()
                ->end() // END LOGGER



            ->end(); // END ROOT CHILDREN

        $this->addServiceSection($rootNode);

        return $treeBuilder;
    }

    private function addServiceSection(ArrayNodeDefinition $node)
    {
        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('service')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('commit_strategy_auto')->defaultValue('neoconnect.transaction.auto_commit_strategy')->end()
                    ->scalarNode('commit_strategy_stack')->defaultValue('neoconnect.transaction.stack_commit_strategy')->end()
                    ->end()
                ->end()
                ->end()
            ->end();
    }
}
