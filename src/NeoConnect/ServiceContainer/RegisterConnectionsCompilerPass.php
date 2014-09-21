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

class RegisterConnectionsCompilerPass implements CompilerPassInterface
{
    protected $processedConfig;

    public function __construct(array $processedConfig)
    {
        $this->processedConfig = $processedConfig;
    }

    public function process(ContainerBuilder $container)
    {
        if (empty($this->processedConfig['connections'])) {
            return;
        }

        if (!$cm = $container->findDefinition('neoconnect.connection_manager')) {
            return;
        }

        $cm->addMethodCall(
            'createConnections',
            array($this->processedConfig)
        );
    }
}
