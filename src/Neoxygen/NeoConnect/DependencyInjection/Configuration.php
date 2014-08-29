<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace Neoxygen\NeoConnect\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('neoconnect');

        $rootNode->children()
            ->arrayNode('connection')
            ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('class')
                        ->defaultValue('Neoxygen\NeoConnect\HttpClient\HttpClient')->end()
                    ->scalarNode('scheme')->defaultValue('http')->end()
                    ->scalarNode('host')->defaultValue('localhost')->end()
                    ->integerNode('port')->defaultValue('7474')->end()
                ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
