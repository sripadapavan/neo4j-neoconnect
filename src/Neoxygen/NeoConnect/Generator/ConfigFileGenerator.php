<?php

namespace Neoxygen\NeoConnect\Generator;

use Symfony\Component\Filesystem\Filesystem,
    Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Yaml\Yaml;

class ConfigFileGenerator
{
    protected $io;
    protected $defaultConfig;
    protected $rootDir;

    public function __construct(Filesystem $io)
    {
        $this->io = $io;
        $this->rootDir = getcwd();
    }

    public function generate()
    {
        $this->ensureTemplateFileExist();
        $this->parseDefaultConfigFile();
        $this->generateUserConfigFile();
        $this->ensureUserConfigFileGeneration();

        return true;
    }

    public function getIO()
    {
        return $this->io;
    }

    public function ensureTemplateFileExist()
    {
        $templates_path = __DIR__.'/../Resources/templates';
        $file_path = $templates_path.'/default_config.yml.dist';

        if (!$this->getIO()->exists($file_path)) {
            throw new \RuntimeException('The template config file is not present. Aborting ...');
        }
        $this->defaultConfig = $file_path;

        return true;
    }

    public function parseDefaultConfigFile()
    {
        if (!$config = Yaml::parse($this->defaultConfig)) {
            throw new \RuntimeException(sprintf('The default config file could not be parsed'));
        }

        return true;
    }

    public function generateUserConfigFile()
    {
        try {
            $this->getIO()->copy($this->defaultConfig, $this->rootDir.'/neoconnect.yml');
        } catch (IOException $e) {
            throw new \RuntimeException(sprintf('Unable to create config file "%s"', $e->getPath()));
        }


        return true;
    }

    public function ensureUserConfigFileGeneration()
    {
        if (!$this->getIO()->exists($this->rootDir.'/neoconnect.yml')) {
            throw new \RuntimeException(sprintf('The configuration file could not be created'));
        }

        return true;
    }
}
