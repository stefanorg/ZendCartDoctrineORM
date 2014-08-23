<?php

namespace ZendCartDoctrineORM;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use ZendCart\Event\CartEvent;
use Zend\EventManager\SharedEventManager;

class Module implements AutoloaderProviderInterface
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $sm = $e->getApplication()->getServiceManager();
        $listener = $sm->get('zendcartdoctrineorm_listener');
        $eventManager->attach($listener);
    }


    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'zendcartdoctrineorm_listener'     => 'ZendCartDoctrineORM\Listener\Factory\CartListenerFactory',
                'zendcartdoctrineorm_cart_service' => 'ZendCartDoctrineORM\Service\Factory\CartServiceFactory'
            ),
        );
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                   __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}
