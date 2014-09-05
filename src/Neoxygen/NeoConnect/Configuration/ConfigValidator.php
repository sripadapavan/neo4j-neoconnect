<?php

namespace Neoxygen\NeoConnect\Configuration;

use Symfony\Component\Yaml\Yaml,
    Symfony\Component\Yaml\Exception\ParseException,
    Symfony\Component\Config\Definition\Processor,
    Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Neoxygen\NeoConnect\Configuration\Definition;

class ConfigValidator
{
    protected $config;
    protected $processedConfig;

    public function validateConfiguration($filePath)
    {
        $this->loadConfiguration($filePath);
        $this->processConfig();

        return $this->processedConfig;
    }

    public function loadConfiguration($filepath)
    {
        try {
            $config = Yaml::parse((string) $filepath);
        } catch (ParseException $e) {
            throw new \InvalidArgumentException(sprintf('Unable to parse the "%s" file', $filepath));
        }
        $this->config = $config;

        return true;
    }

    public function processConfig()
    {
        $processor = new Processor();
        $definition = new Definition();

        try {
            $this->processedConfig = $processor->processConfiguration($definition, $this->config);
        } catch (InvalidConfigurationException $e) {
            throw new \InvalidArgumentException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }

        return true;
    }
}
