<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace NeoConnect\Config;

use Symfony\Component\Yaml\Yaml;

class Loader
{

    public function parseConfigurationFile($filePath)
    {
        return Yaml::parse($filePath);
    }
}
