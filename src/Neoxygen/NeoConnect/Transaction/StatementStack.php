<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace Neoxygen\NeoConnect\Transaction;

use Doctrine\Common\Collections\ArrayCollection;

class StatementStack
{
    protected $statements;

    public function __construct()
    {
        $this->statements = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getStatements()
    {
        return $this->statements;
    }

    /**
     * @param ArrayCollection $statements
     */
    public function setStatements(ArrayCollection $statements)
    {
        $this->statements = $statements;
    }

    /**
     * @param Statement $statement
     */
    public function addStatement(Statement $statement)
    {
        $this->statements->add($statement);
    }
}
