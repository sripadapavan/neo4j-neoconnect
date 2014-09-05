<?php

namespace spec\Neoxygen\NeoConnect\Configuration;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Neoxygen\NeoConnect\Generator\ConfigFileGenerator;
use Symfony\Component\Filesystem\Filesystem,
    Symfony\Component\Yaml\Yaml;

class ConfigValidatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Neoxygen\NeoConnect\Configuration\ConfigValidator');
    }

    function it_should_load_a_configuration_file()
    {
        $this->loadConfiguration($this->getConfigurationFilePath())->shouldReturn(true);
    }

    function it_should_throw_error_when_the_config_file_can_not_be_parsed(Yaml $yaml)
    {
        $yaml->parse($this->getNonYamlFile())->willReturn(false);
        $this->shouldThrow('\InvalidArgumentException')->during('loadConfiguration', array($this->getNonYamlFile()));
    }

    function it_should_process_the_configuration()
    {
        $this->loadConfiguration($this->getConfigurationFilePath());
        $this->processConfig(Argument::any())->shouldReturn(true);
    }

    function it_should_throw_error_if_configuration_is_invalid()
    {
        $this->loadConfiguration($this->getInvalidFile());
        $this->shouldThrow('\InvalidArgumentException')->during('processConfig', array(Argument::any(), Argument::any()));
    }

    function it_should_load_and_validate_in_one_step()
    {
        $this->validateConfiguration($this->getConfigurationFilePath())->shouldBeArray();
    }

    private function getConfigurationFilePath()
    {
        $cwd = getcwd();
        $file = $cwd.'/neoconnect.yml';
        if (!file_exists($file)) {
            $fs = new Filesystem();
            $gen = new ConfigFileGenerator($fs);
            $gen->generate();
        }

        return $file;
    }

    private function getInvalidFile()
    {
        return __DIR__.'/templates/invalid_config.yml';
    }

    private function getNonYamlFile()
    {
        return getcwd().'/README.md';
    }
}
