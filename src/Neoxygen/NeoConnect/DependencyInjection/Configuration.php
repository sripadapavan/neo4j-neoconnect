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
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

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
            ->arrayNode('transaction')
            ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('mode')->defaultValue('auto')->end()
                    ->arrayNode('commit_strategy')
                    ->addDefaultsIfNotSet()
                        ->children()
                        ->scalarNode('strategy')->defaultValue('auto')->end()
                        ->scalarNode('class')->end()
                    ->end()
                ->end()
            ->end()
        ->end();

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
                    ->end()
                ->end()
                ->end()
            ->end();
    }
}
