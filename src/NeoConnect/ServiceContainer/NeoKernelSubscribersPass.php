<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace NeoConnect\ServiceContainer;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class NeoKernelSubscribersPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {

        $definition = $container->getDefinition(
            'neoconnect.event_dispatcher'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'neo_kernel.event_subscriber'
        );

        foreach ($taggedServices as $id => $attributes) {
            $taggedServiceDefinition = $container->getDefinition($id);
            $definition->addMethodCall(
                'addSubscriberService',
                array($id, $taggedServiceDefinition->getClass())
            );
        }
    }
}