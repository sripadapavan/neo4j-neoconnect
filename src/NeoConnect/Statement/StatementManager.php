<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace NeoConnect\Statement;

use NeoConnect\Statement\Statement;

class StatementManager
{

    public function createStatement($query, array $parameters = array(), array $resultDataContents = array())
    {
        return new Statement($query, $parameters, $resultDataContents);
    }
}
