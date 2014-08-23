<?php

namespace ZendCartDoctrineORM\Adapter;

use Doctrine\Common\Persistence\ObjectManager;
use ZendCartDoctrineORM\Adapter\CartCookieAdapterInterface;

class DoctrineCartAdapter implements CartAdapterInterface {

    protected $objectManager;

    function __construct(ObjectManager $om){
        $this->objectManager = $om;
    }


}