<?php

namespace ZendCartDoctrineORM\Service;

use Doctrine\Common\Persistence\ObjectManager;
use ZendCartDoctrineORM\Entity\CartEntityInterface as CartInterface;
use ZendCartDoctrineORM\Entity\CartItemInterface;
use ZendCartDoctrineORM\Hydrator\CartItemHydrator;

class CartService implements CartServiceInterface
{
    protected $objectManager;
    protected $cartEntityClass = 'ZendCartDoctrineORM\Entity\Cart';
    protected $hydrator;
    protected $cartItemClass = 'ZendCartDoctrineORM\Entity\CartItem';

    function __construct(ObjectManager $om){
        $this->objectManager = $om;
        $this->hydrator = new CartItemHydrator();
    }

    public function findById($cartId){
        return $this->objectManager->getRepository($this->cartEntityClass)->findOneBy(['id'=>$cartId]);
    }

    public function persist(CartInterface $cart){
        $this->objectManager->persist($cart);
        $this->objectManager->flush();
    }

    public function findItemBy($cartId, $tokenId)
    {
        return $this->objectManager->getRepository($this->cartItemClass)->findOneBy(['cart'=>$cartId, 'itemToken'=>$tokenId]);
    }

    public function updateCartItem(CartItemInterface $item)
    {
        $this->objectManager->persist($item);
        $this->objectManager->flush();
    }

    public function addItemToCart(CartItemInterface $item, $cartId)
    {
        $cart = $this->findById($cartId);
        if($cart){
            $item->setCart($cart);
            $this->objectManager->persist($item);
            $this->objectManager->flush();
        }
    }

    public function removeCartItem($cartId, $tokenId)
    {
        $item = $this->findItemBy($cartId, $tokenId);
        if($item){
            $this->objectManager->remove($item);
            $this->objectManager->flush();
        }
    }

    public function deleteCart($cartId)
    {
        $cart = $this->findById($cartId);
        if($cart){
            $this->objectManager->remove($cart);
            $this->objectManager->flush();
        }
    }

    public function getHydrator()
    {
        return $this->hydrator;
    }

    /**
     * retrive ZendCart array from db
     * @return [type] [description]
     */
    public function restoreZendCartArray($cartId)
    {
        //extract cart items
        $zfProducts = array();

        //get cart
        $cart = $this->findById($cartId);
        if($cart){
            foreach ($cart->getItems() as $cartItem) {
                $zfProducts[$cartItem->getItemToken()] = $this->hydrator->extract($cartItem);
            }
        }

        return $zfProducts;
    }
}
