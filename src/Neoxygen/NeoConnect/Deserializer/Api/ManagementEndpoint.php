<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace Neoxygen\NeoConnect\Deserializer\Api;

use JMS\Serializer\Annotation\Type;

class ManagementEndpoint
{
    /**
     * @Type("array")
     */
    protected $services;

    /**
     * @return mixed
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * @param mixed $services
     */
    public function setServices(array $services)
    {
        $this->services = $services;
    }
}
