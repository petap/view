<?php

namespace Petap\View;

use Laminas\ModuleManager\Feature\BootstrapListenerInterface;
use Laminas\EventManager\EventInterface;
use Laminas\Mvc\MvcEvent;
use Laminas\EventManager\EventManager;

/**
 * Class Module
 * @package Petap\View
 */
class Module implements BootstrapListenerInterface
{
    /**
     * {@inheritDoc}
     */
    public function onBootstrap(EventInterface $e)
    {
        /** @var EventManager $eventManager */
        $eventManager = $e->getApplication()->getEventManager();

        $injectLayoutListener = new BuildViewListener();

        $sharedEvents = $eventManager->getSharedManager();
        $sharedEvents->attach(
            'Laminas\Stdlib\DispatchableInterface',
            MvcEvent::EVENT_DISPATCH,
            [$injectLayoutListener, 'injectLayout'],
            -70
        );
    }
}