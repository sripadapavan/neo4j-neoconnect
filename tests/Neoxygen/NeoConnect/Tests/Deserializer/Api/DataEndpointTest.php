<?php

namespace Neoxygen\NeoConnect\Tests\Deserializer\Api;

use Neoxygen\NeoConnect\Deserializer\Api\DataEndpoint,
    Neoxygen\NeoConnect\ConnectionBuilder;

class DataEndpointTest extends \PHPUnit_Framework_TestCase
{
    public function testExtensionsIsMutable()
    {
        $endpoint = new DataEndpoint();
        $extensions = $this->getDataEndpoint()->getExtensions();
        $endpoint->setExtensions($extensions);
        $this->assertEquals($endpoint->getExtensions(), $extensions);
    }

    public function testNodeIsMutable()
    {
        $endpoint = new DataEndpoint();
        $node = $this->getDataEndpoint()->getNode();
        $endpoint->setNode($node);
        $this->assertEquals($endpoint->getNode(), $node);
    }

    public function testNodeIndexIsMutable()
    {
        $endpoint = new DataEndpoint();
        $nodeIndex = $this->getDataEndpoint()->getNodeIndex();
        $endpoint->setNodeIndex($nodeIndex);
        $this->assertEquals($endpoint->getNodeIndex(), $nodeIndex);
    }

    public function testRelationshipIndexIsMutable()
    {
        $endpoint = new DataEndpoint();
        $relIndex = $this->getDataEndpoint()->getRelationshipIndex();
        $endpoint->setRelationshipIndex($relIndex);
        $this->assertEquals($endpoint->getRelationshipIndex(), $relIndex);
    }

    public function testRelationshipTypeIsMutable()
    {
        $endpoint = new DataEndpoint();
        $relTypes = $this->getDataEndpoint()->getRelationshipTypes();
        $endpoint->setRelationshipTypes($relTypes);
        $this->assertEquals($endpoint->getRelationshipTypes(), $relTypes);
    }

    public function testExtensionsInfosIsMutable()
    {
        $endpoint = new DataEndpoint();
        $exinfo = $this->getDataEndpoint()->getExtensionsInfo();
        $endpoint->setExtensionsInfo($exinfo);
        $this->assertEquals($endpoint->getExtensionsInfo(), $exinfo);
    }

    public function testBatchIsMutable()
    {
        $endpoint = new DataEndpoint();
        $batch = $this->getDataEndpoint()->getBatch();
        $endpoint->setBatch($batch);
        $this->assertEquals($endpoint->getBatch(), $batch);
    }

    public function testCypherIsMutable()
    {
        $endpoint = new DataEndpoint();
        $cypher = $this->getDataEndpoint()->getCypher();
        $endpoint->setCypher($cypher);
        $this->assertEquals($endpoint->getCypher(), $cypher);
    }

    public function testIndexesIsMutable()
    {
        $endpoint = new DataEndpoint();
        $indexes = $this->getDataEndpoint()->getIndexes();
        $endpoint->setIndexes($indexes);
        $this->assertEquals($endpoint->getIndexes(), $indexes);
    }

    public function testConstraintsIsMutable()
    {
        $endpoint = new DataEndpoint();
        $constraints = $this->getDataEndpoint()->getConstraints();
        $endpoint->setConstraints($constraints);
        $this->assertEquals($endpoint->getConstraints(), $constraints);
    }

    public function testTransactionIsMutable()
    {
        $endpoint = new DataEndpoint();
        $tx = $this->getDataEndpoint()->getTransaction();
        $endpoint->setTransaction($tx);
        $this->assertEquals($endpoint->getTransaction(), $tx);
    }

    public function testNodeLabelsIsMutable()
    {
        $endpoint = new DataEndpoint();
        $labels = $this->getDataEndpoint()->getNodeLabels();
        $endpoint->setNodeLabels($labels);
        $this->assertEquals($endpoint->getNodeLabels(), $labels);
    }

    public function testNeoVersionIsMutable()
    {
        $endpoint = new DataEndpoint();
        $v = $this->getDataEndpoint()->getNeo4jVersion();
        $endpoint->setNeo4jVersion($v);
        $this->assertEquals($endpoint->getNeo4jVersion(), $v);
    }

    private function getDataEndpoint()
    {
        $conn = $this->getBuilder();
        $dataEndpoint = $conn->getApiDiscovery()->getDataEndpoint();

        return $dataEndpoint;
    }

    private function getBuilder()
    {
        $conn = ConnectionBuilder::create()->build();

        return $conn;
    }
}
