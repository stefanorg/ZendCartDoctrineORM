<?php
namespace ZendCartDoctrineORM\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZendCartDoctrineORM\Service\CartService;

/**
* Factory
*/
class CartServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $sm)
    {
        $om = $sm->get('Doctrine\ORM\EntityManager');
    	$service = new CartService($om);
        return $service;
    }
}