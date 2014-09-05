<?php

namespace spec\Neoxygen\NeoConnect\Generator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Filesystem\Filesystem;

class ConfigFileGeneratorSpec extends ObjectBehavior
{
    function let(Filesystem $io)
    {
        $this->beConstructedWith($io);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Neoxygen\NeoConnect\Generator\ConfigFileGenerator');
    }

    function it_should_have_an_IO_service_for_file_manipulation()
    {
        $this->getIO()->shouldHaveType('Symfony\Component\Filesystem\Filesystem');
    }

    function it_should_ensures_a_config_file_template_exist($io)
    {
        $io->exists(Argument::any())->willReturn(true);
        $this->ensureTemplateFileExist()->shouldReturn(true);
    }

    function it_should_throw_an_error_if_config_file_template_is_not_found($io)
    {
        $io->exists(Argument::any())->willReturn(false);
        $this->shouldThrow('\RuntimeException')->during('ensureTemplateFileExist');
    }

    function it_should_parse_the_default_config_file($io)
    {
        $io->exists(Argument::any())->willReturn(true);
        $this->ensureTemplateFileExist();
        $this->parseDefaultConfigFile()->shouldReturn(true);
    }

    function it_should_throw_exception_if_the_default_config_file_can_not_be_parsed($io)
    {
        $io->exists(Argument::any())->willReturn(false);
        $this->shouldThrow('\RuntimeException')->during('parseDefaultConfigFile');
    }

    function it_should_create_the_new_config_file($io)
    {
        $io->exists(Argument::any())->willReturn(true);
        $io->copy(Argument::any(), Argument::any())->willReturn(true);
        $this->ensureTemplateFileExist();
        $this->parseDefaultConfigFile();
        $this->generateUserConfigFile()->shouldReturn(true);
    }

    function it_should_ensure_presence_of_user_config_file($io)
    {
        $io->exists(Argument::any())->willReturn(true);
        $this->ensureUserConfigFileGeneration()->shouldReturn(true);
    }

    function it_should_do_all_these_steps_in_one_call($io)
    {
        $io->exists(Argument::any())->willReturn(true);
        $io->copy(Argument::any(), Argument::any())->willReturn(true);
        $io->exists(Argument::any())->willReturn(true);
        $this->generate()->shouldReturn(true);
    }
}
