<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace Neoxygen\NeoConnect\EventDispatcher;

use Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher,
    Symfony\Component\DependencyInjection\ContainerInterface;

class CAEventDispatcher
{
    protected $dispatcher;

    public function __construct(ContainerInterface $container)
    {
        $this->dispatcher = new ContainerAwareEventDispatcher($container);
    }

    public function addSubscriberService($id, $class)
    {
        return $this->dispatcher->addSubscriberService(
            $id,
            $class
        );
    }

    public function dispatch($name, $event)
    {
        return $this->dispatcher->dispatch($name, $event);
    }

    public function getDispatcher()
    {
        return $this->dispatcher;
    }
}
