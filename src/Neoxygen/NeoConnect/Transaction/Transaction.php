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
use Neoxygen\NeoConnect\Statement\Statement;

class Transaction
{
    protected $statements;

    public function __construct()
    {
        $this->statements = new ArrayCollection();
    }

    /**
     * @return ArrayCollection Statements to be sent in the transaction
     */
    public function getStatements()
    {
        return $this->statements;
    }

    /**
     * @param  ArrayCollection $statements
     * @return $this
     */
    public function setStatements(ArrayCollection $statements)
    {
        $this->statements = $statements;

        return $this;
    }

    /**
     * @param  Statement $statement
     * @return $this
     */
    public function addStatement(Statement $statement)
    {
        $this->statements->add($statement);

        return $this;
    }

}
