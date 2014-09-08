<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace NeoConnect\Statement;

use NeoConnect\Statement\Statement,
    NeoConnect\NeoEvents,
    NeoConnect\Event\NeoKernelEvents\getStatementFromQueryEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class StatementManager implements EventSubscriberInterface
{

    public function createStatement($query, array $parameters = array(), array $resultDataContents = array())
    {
        return new Statement($query, $parameters, $resultDataContents);
    }

    public static function getSubscribedEvents()
    {
        return array(
            NeoEvents::NEO_KERNEL_STATEMENT => array(
                'transformQueryToStatement'
            )
        );
    }

    public function transformQueryToStatement(getStatementFromQueryEvent $event)
    {
        $statement = $this->createStatement($event->getQuery(), $event->getParameters());
        $event->setStatement($statement);
    }
}
