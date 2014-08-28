<?php

namespace ZendCartDoctrineORM\Hydrator;

use Zend\Stdlib\Hydrator\HydratorInterface;
use \Datetime;

class CartItemHydrator implements HydratorInterface
{
    /**
     *       $this->cartItemId    = isset($config['id'])          ? $config['id']         : null;
     *       $this->qty           = isset($config['qty'])         ? $config['qty']        : 0;
     *       $this->description   = isset($config['description']) ? $config['description']: "";
     *       $this->price         = isset($config['price'])       ? $config['price']      : null;
     *       $this->name          = isset($config['name'])        ? $config['name']       : '';
     *       //$this->options      = isset($config['options'])    ? $config['options']    : 0;
     *       $this->vat           = isset($config['vat'])         ? $config['vat']        : 0;
     *       $this->itemToken     = isset($config['itemToken'])   ? $config['itemToken']  : null;
     *
     *       $this->date          = isset($config['date'])        ? Datetime::createFromFormat('Y-m-d H:i:s', $config['date']) : new Datetime();
     * @param  [type] $object [description]
     * @return [type]         [description]
     */
    public function extract($object)
    {
        $result = array(
            'id'                     => $object->getCartItemId(),
            'description'            => $object->getDescription(),
            'price'                  => $object->getPrice() ?: 0.00,
            'qty'                    => $object->getQty() ?: 0,
            'vat'                    => $object->getVat() ?: 0,
            'itemToken'              => $object->getItemToken(),
            'name'                   => $object->getName(),
            'date'                   => $object->getDate() ? $object->getDate()->format('Y-m-d H:i:s') : Datetime::createFromFormat('Y-m-d H:i:s', new Datetime()),
            'options'                => $object->getOptions() ?: array()
        );

        return $result;
    }

    public function hydrate(array $data, $object)
    {
        $object->setCartItemId($data['id'])
            ->setDescription($data['description'])
            ->setPrice($data['price'])
            ->setQty($data['qty'])
            ->setVat($data['vat'])
            ->setDate(Datetime::createFromFormat('Y-m-d H:i:s', $data['date']))
            ->setItemToken($data['itemToken'])
            ->setName($data['name'])
            ->setOptions($data['options']);

        return $object;
    }
}

