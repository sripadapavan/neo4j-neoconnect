<?php

namespace spec\NeoConnect\Config;

use spec\NeoBaseSpec;

use NeoConnect\Config\Definition;

class ValidatorSpec extends NeoBaseSpec
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('NeoConnect\Config\Validator');
    }

    public function it_should_have_a_definition_by_default()
    {
        $this->getDefinition()->shouldHaveType('NeoConnect\Config\Definition');
    }

    public function it_should_have_a_config_loader_by_default()
    {
        $this->getLoader()->shouldHaveType('NeoConnect\Config\Loader');
    }

    public function it_should_validate_loaded_config_against_definition()
    {
        $config = $this->createConfig();
        $this->validate($config)->shouldBeArray();
    }
}
