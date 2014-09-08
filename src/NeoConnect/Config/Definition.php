<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace NeoConnect\Config;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Definition implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('neoconnect');

        $supportedSchemes = array('http', 'https');
        $supportedStrategies = array('manual_flush', 'auto_flush', 'queue_limit_trigger_flush');

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
                    ->end() // End Prototype CH
                ->end() // End Prototype
            ->end() // End Connections

            ->arrayNode('flush_strategy') // FLUSH STRATEGY
            ->prototype('array')
                ->children()
                    ->scalarNode('strategy')->defaultValue('manual_flush')
                        ->validate()
                        ->ifNotInArray($supportedStrategies)
                        ->thenInvalid('The Flush Strategy %s is not valid, please choose one of '.json_encode($supportedStrategies))
                        ->end()
                    ->end() // END STRATEGY
                ->end() // END FLUSH STRATEGY CHILDREN
            ->end() //END PROTOTYPE
            ->end() // END FLUSH STRATEGY
        ->end(); // END ROOT CHILDREN

        return $treeBuilder;
    }
}
