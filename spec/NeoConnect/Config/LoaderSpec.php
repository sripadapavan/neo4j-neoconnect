<?php

namespace spec\NeoConnect\Config;

use spec\NeoBaseSpec;

class LoaderSpec extends NeoBaseSpec
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('NeoConnect\Config\Loader');
    }

    public function it_should_load_a_yaml_file_from_a_path()
    {
        $config = $this->createConfig();
        $this->parseConfigurationFile($config)->shouldBeArray();
    }
}
