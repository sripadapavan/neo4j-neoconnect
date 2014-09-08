<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace NeoConnect\Config;

use NeoConnect\Config\Definition,
    NeoConnect\Config\Loader;
use Symfony\Component\Config\Definition\Processor,
    Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

class Validator
{
    protected $definition;
    protected $loader;

    public function __construct()
    {
        $this->definition = new Definition();
        $this->loader = new Loader();
    }

    public function getDefinition()
    {
        return $this->definition;
    }

    public function getLoader()
    {
        return $this->loader;
    }

    public function validate($configFilePath)
    {
        $userConfig = $this->loader->parseConfigurationFile($configFilePath);
        $processor = new Processor();
        $processedConfig = $processor->processConfiguration($this->definition, $userConfig);

        return $processedConfig;
    }
}
