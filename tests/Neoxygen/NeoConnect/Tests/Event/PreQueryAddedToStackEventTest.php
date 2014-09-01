<?php

namespace Neoxygen\NeoConnect\Tests\Event;

use Neoxygen\NeoConnect\Event\PreQueryAddedToStackEvent,
    Neoxygen\NeoConnect\Statement\Statement;

class PreQueryAddedToStackEventTest extends \PHPUnit_Framework_TestCase
{
    public function testEvent()
    {
        $statement = new Statement('MATCH (n) RETURN n');
        $event = new PreQueryAddedToStackEvent($statement);

        $this->assertEquals($statement, $event->getStatement());
    }
}
