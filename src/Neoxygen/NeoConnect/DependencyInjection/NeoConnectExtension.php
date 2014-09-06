<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace Neoxygen\NeoConnect\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;

class NeoConnectExtension implements ExtensionInterface
{

    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $processor = new Processor();
        $config = $processor->processConfiguration($configuration, $configs);

        //print_r($config);

        foreach ($config['connection'] as $key => $value) {
            $container->setParameter($this->getAlias() . '.connection.' . $key, $value);
        }
        foreach ($config['transaction'] as $key => $value) {
            if (!is_array($value)) {
                $container->setParameter($this->getAlias() . '.transaction.' . $key, $value);
            }

        }
        foreach ($config['transaction']['commit_strategy'] as $key => $value) {
            if (!is_array($value)) {
                $container->setParameter($this->getAlias() . '.transaction.commit_strategy.' . $key, $value);
            }

        }

        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config/services')
        );
        $loader->load('services.yml');

        // Defining Commit Strategy
        $commitStrategy = $config['transaction']['commit_strategy']['strategy'];
        if ('custom' !== $commitStrategy) {
            $loader->load('commit_strategy/' . $commitStrategy . '.yml');
            $container->setAlias('neoconnect.commit_strategy', $config['service']['commit_strategy_' . $commitStrategy]);
        }

        // Registering Loggers


    }

    public function getAlias()
    {
        return 'neoconnect';
    }

    public function getXsdValidationBasePath()
    {
        return __DIR__.'/../Resources/config/';
    }

    public function getNamespace()
    {
        return 'http://www.example.com/symfony/schema/';
    }
}
