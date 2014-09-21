<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace NeoConnect\ServiceContainer;

use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class FlushStrategyServicesPass implements CompilerPassInterface
{
    protected $processedConfig;

    public function __construct(array $processedConfig)
    {
        $this->processedConfig = $processedConfig;
    }

    public function process(ContainerBuilder $container)
    {
        if (empty($this->processedConfig['flush_strategy_classes'])) {
            return;
        }

        if (!$manager = $container->findDefinition('neoconnect.flush_strategy_manager')) {
            return;
        }

        $defaultFlush = $container->getParameter('neoconnect.default_flush_strategy');

        foreach ($this->processedConfig['flush_strategy_classes'] as $strategyAlias => $class) {
            $newServiceId = 'neoconnect.flush_strategy.'.$strategyAlias;
            $definition = new Definition($newServiceId);
            $definition->setClass($class);
            $definition->setLazy(true);
            $definition->addTag('neoconnect.flush_strategy_service');

            $container->setDefinition($newServiceId, $definition);
            $manager->addMethodCall(
                'registerStrategyService',
                array($strategyAlias, $definition)
            );
        }

        $cm = $container->findDefinition('neoconnect.connection_manager');
        foreach ($this->processedConfig['flush_strategy'] as $connectionAlias => $stratAlias) {
            if (!$container->hasDefinition('neoconnect.flush_strategy.'.$stratAlias['strategy'])) {
                throw new \InvalidArgumentException(sprintf('There is no "%s" flush strategy available', $stratAlias['strategy']));
            }
            $cm->addMethodCall(
                'assignFlushStrategy',
                array($connectionAlias, $stratAlias['strategy'])
            );

        }
        $cm->addMethodCall(
            'assignDefaultStrategy',
            array($defaultFlush)
        );
    }
}
