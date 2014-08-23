<?php

namespace ZendCartDoctrineORM\Service;

use ZendCartDoctrineORM\Entity\CartEntityInterface as CartInterface;
use ZendCartDoctrineORM\Entity\CartItemInterface;

interface CartServiceInterface {

    /**
     * Find the cart based on the cart ID
     *
     * @return CartInterface
     */
    public function findById($cartId);
    public function findItemBy($cartId, $tokenId);
    public function updateCartItem(CartItemInterface $item);
    public function deleteCart($cartId);
    /**
     * Insert or update the cart in storage
     *
     * @param CartInterface cart to update
     * @return null
     */
    public function persist(CartInterface $cart);

    /**
     * Add an item to a cart
     *
     * @param CartItemInterface item to add
     * @param CartInterface cart to modify -- default to current session's cart if null
     * @return CartServiceInterface
     */
    public function addItemToCart(CartItemInterface $item, $cartId);

    /**
     * Remove an item from a cart
     *
     * @param string cartId cart item ID of item to remove
     * @param string tokenId Item token to remove
     * @return CartServiceInterface
     */
    public function removeCartItem($cartId, $tokenId);
}