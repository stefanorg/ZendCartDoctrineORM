<?php
namespace ZendCartDoctrineORM\Listener\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZendCartDoctrineORM\Listener\CartListener;

/**
* Factory
*/
class CartListenerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $sm)
    {
        $service = $sm->get('zendcartdoctrineorm_cart_service');
        $listener = new CartListener($service);
        $listener->setLogger($sm->get('jcommerce.log'));
        return $listener;
    }
}