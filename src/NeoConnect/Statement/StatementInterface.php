<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace NeoConnect\Statement;

interface StatementIterface
{
    public function getQuery();
    public function setQuery($query);
    public function getParameters();
    public function setParameters(array $parameters);
    public function getResultDataContents();
    public function setResultDataContents(array $resultDataContents);
    public function hasParameters();
}