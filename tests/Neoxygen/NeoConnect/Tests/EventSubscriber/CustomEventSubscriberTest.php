<?php

namespace Neoxygen\NeoConnect\Tests\EventSubscriber;

use Neoxygen\NeoConnect\EventSubscriber\BaseEventSubscriber,
    Neoxygen\NeoConnect\Event\PreQueryAddedToStackEvent;

class CustomEventSubscriberTest extends BaseEventSubscriber
{
    public static function getSubscribedEvents()
    {
        return array(
            'pre.query_add_to_stack' => array(
                array('verifyGraphResultDataContentIsSet', 20),
                array('replaceCreateByMerge', 10)
            )
        );
    }

    public function verifyGraphResultDataContentIsSet(PreQueryAddedToStackEvent $event)
    {
        $statement = $event->getStatement();
        if (!in_array('graph', $statement->getResultDataContents())) {
            $result = $statement->getResultDataContents();
            array_push($result, 'graph');
            $statement->setResultDataContents($result);

        }
    }

    public function replaceCreateByMerge(PreQueryAddedToStackEvent $event)
    {
        $statement = $event->getStatement();
        $q = $statement->getStatement();
        $newQuery = str_replace('CREATE', 'MERGE', $q);
        $statement->setStatement($newQuery);
    }
}
