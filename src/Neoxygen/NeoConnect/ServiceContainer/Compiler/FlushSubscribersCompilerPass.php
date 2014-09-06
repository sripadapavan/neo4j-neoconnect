<?php

namespace Neoxygen\NeoConnect\ServiceContainer\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class FlushSubscribersCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('neoconnect.ca_event_dispatcher')) {
            return;
        }

        $definition = $container->getDefinition(
            'neoconnect.ca_event_dispatcher'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'flush.event_subscriber'
        );

        foreach ($taggedServices as $id => $attributes) {

            $definition->addMethodCall(
                'addSubscriberService',
                array($attributes[0]['service'], 'Neoxygen\\NeoConnect\\Flusher\\'.$attributes[0]['class'])
            );
        }
    }
}