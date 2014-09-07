<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace NeoConnect\Configuration;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

class Definition implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('neoconnect');

        $supportedSchemes = array('http', 'https');
        $supportedStrategies = array('manual', 'auto');

        $rootNode->children() // Children
        ->arrayNode('connections') //Connections
            ->requiresAtLeastOneElement()
                ->prototype('array')
                    ->children()  //Conenctions CH
                        ->scalarNode('scheme')->defaultValue('http')
                            ->validate()
                            ->ifNotInArray($supportedSchemes)
                            ->thenInvalid('The scheme %s is not valid, please choose one of '.json_encode($supportedSchemes))
                            ->end() // End validation scheme
                        ->end() // END Scheme
                        ->scalarNode('host')->defaultValue('localhost')->end()
                        ->integerNode('port')->defaultValue('7474')->end()
                        ->arrayNode('flush_strategy') // COMMIT STRATEGY
                            ->addDefaultsIfNotSet()
                            ->children() // COMMIT STRATEGY CHILDREN
                                ->scalarNode('type')->isRequired()->canNotBeEmpty()->defaultValue('manual') //STRATEGY
                                    ->validate() // STRATEGY VALIDATION
                                    ->ifNotInArray($supportedStrategies)
                                    ->thenInvalid('The commit strategy %s is not supported, please choose one of'.
                                    json_encode($supportedStrategies))
                                    ->end() // END VALIDATION
                                ->end() // END STRATEGY
                            ->end() // END COMMIT STRATEGY CHILDREN
                        ->end() // END COMMIT STRATEGY
                    ->end() // End Prototype CH
                ->end() // End Prototype
            ->end() // End Connections
        ->end(); // END ROOT CHILDREN

        return $treeBuilder;
    }
}
