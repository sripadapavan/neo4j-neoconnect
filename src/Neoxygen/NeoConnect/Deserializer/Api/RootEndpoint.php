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

class RootEndpoint
{
    /**
     * @Type("string")
     */
    protected $management;

    /**
     * @Type("string")
     */
    protected $data;

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = (string) $data;
    }

    public function getManagement()
    {
        return $this->management;
    }

    public function setManagement($management)
    {
        $this->management = (string) $management;
    }
}
