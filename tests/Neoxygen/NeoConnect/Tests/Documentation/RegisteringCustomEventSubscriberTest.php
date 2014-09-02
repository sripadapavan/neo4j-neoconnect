<?php

namespace Neoxygen\NeoConnect\Tests\Documentation;

use Neoxygen\NeoConnect\ConnectionBuilder,
    Neoxygen\NeoConnect\Tests\EventSubscriber\CustomEventSubscriberTest;

class RegisteringCustomEventSubscriberTest extends \PHPUnit_Framework_TestCase
{
    public function testCustomSubscriberIsRegistered()
    {
        $myCustomSubscriber = new CustomEventSubscriberTest();
        $conn = ConnectionBuilder::create()
            ->addEventSubscriber($myCustomSubscriber)
            ->build();

        $dispatcher = $conn->getEventDispatcherService();
        $listeners = $dispatcher->getListeners();
        $this->assertTrue($this->verifySubscriberExist($listeners['pre.query_add_to_stack'], $myCustomSubscriber));
    }

    public function verifySubscriberExist($listeners, $subscriber)
    {
        foreach ($listeners as $l) {
            if ($l[0] == $subscriber) {
                return true;
            }
        }

        return false;
    }
}
