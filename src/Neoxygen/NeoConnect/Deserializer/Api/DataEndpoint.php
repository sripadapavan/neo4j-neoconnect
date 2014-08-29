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

class DataEndpoint
{
    /**
     * @Type("array")
     */
    protected $extensions;

    /**
     * @Type("string")
     */
    protected $node;

    /**
     * @Type("string")
     */
    protected $node_index;

    /**
     * @Type("string")
     */
    protected $relationship_index;

    /**
     * @Type("string")
     */
    protected $relationship_types;

    /**
     * @Type("string")
     */
    protected $extensions_info;

    /**
     * @Type("string")
     */
    protected $batch;

    /**
     * @Type("string")
     */
    protected $cypher;

    /**
     * @Type("string")
     */
    protected $indexes;

    /**
     * @Type("string")
     */
    protected $constraints;

    /**
     * @Type("string")
     */
    protected $transaction;

    /**
     * @Type("string")
     */
    protected $node_labels;

    /**
     * @Type("string")
     */
    protected $neo4j_version;

    /**
     * @return mixed
     */
    public function getBatch()
    {
        return $this->batch;
    }

    /**
     * @param mixed $batch
     */
    public function setBatch($batch)
    {
        $this->batch = $batch;
    }

    /**
     * @return mixed
     */
    public function getConstraints()
    {
        return $this->constraints;
    }

    /**
     * @param mixed $constraints
     */
    public function setConstraints($constraints)
    {
        $this->constraints = $constraints;
    }

    /**
     * @return mixed
     */
    public function getCypher()
    {
        return $this->cypher;
    }

    /**
     * @param mixed $cypher
     */
    public function setCypher($cypher)
    {
        $this->cypher = $cypher;
    }

    /**
     * @return mixed
     */
    public function getExtensions()
    {
        return $this->extensions;
    }

    /**
     * @param mixed $extensions
     */
    public function setExtensions($extensions)
    {
        $this->extensions = $extensions;
    }

    /**
     * @return mixed
     */
    public function getExtensionsInfo()
    {
        return $this->extensions_info;
    }

    /**
     * @param mixed $extensions_info
     */
    public function setExtensionsInfo($extensions_info)
    {
        $this->extensions_info = $extensions_info;
    }

    /**
     * @return mixed
     */
    public function getIndexes()
    {
        return $this->indexes;
    }

    /**
     * @param mixed $indexes
     */
    public function setIndexes($indexes)
    {
        $this->indexes = $indexes;
    }

    /**
     * @return mixed
     */
    public function getNeo4jVersion()
    {
        return $this->neo4j_version;
    }

    /**
     * @param mixed $neo4j_version
     */
    public function setNeo4jVersion($neo4j_version)
    {
        $this->neo4j_version = $neo4j_version;
    }

    /**
     * @return mixed
     */
    public function getNode()
    {
        return $this->node;
    }

    /**
     * @param mixed $node
     */
    public function setNode($node)
    {
        $this->node = $node;
    }

    /**
     * @return mixed
     */
    public function getNodeIndex()
    {
        return $this->node_index;
    }

    /**
     * @param mixed $node_index
     */
    public function setNodeIndex($node_index)
    {
        $this->node_index = $node_index;
    }

    /**
     * @return mixed
     */
    public function getNodeLabels()
    {
        return $this->node_labels;
    }

    /**
     * @param mixed $node_labels
     */
    public function setNodeLabels($node_labels)
    {
        $this->node_labels = $node_labels;
    }

    /**
     * @return mixed
     */
    public function getRelationshipIndex()
    {
        return $this->relationship_index;
    }

    /**
     * @param mixed $relationship_index
     */
    public function setRelationshipIndex($relationship_index)
    {
        $this->relationship_index = $relationship_index;
    }

    /**
     * @return mixed
     */
    public function getRelationshipTypes()
    {
        return $this->relationship_types;
    }

    /**
     * @param mixed $relationship_types
     */
    public function setRelationshipTypes($relationship_types)
    {
        $this->relationship_types = $relationship_types;
    }

    /**
     * @return mixed
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * @param mixed $transaction
     */
    public function setTransaction($transaction)
    {
        $this->transaction = $transaction;
    }
}
