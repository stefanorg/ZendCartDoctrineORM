<?php
namespace ZendCartDoctrineORM\Listener;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use ZendCart\Event\CartEvent;
use Zend\EventManager\Event;
use ZendCartDoctrineORM\Service\CartService;
use ZendCartDoctrineORM\Service\CartServiceInterface;
use ZendCartDoctrineORM\Entity\Cart;
use ZendCartDoctrineORM\Entity\CartItem;

class CartListener implements ListenerAggregateInterface
{
    protected $listeners = array();
    /** @var  CartService */
    protected $cartService;

    protected $logger;

    function __construct(CartServiceInterface $cartService){
        $this->cartService = $cartService;
    }

    /**
     * {@inheritDoc}
     */
    public function attach(EventManagerInterface $events)
    {
        $sharedEvents      = $events->getSharedManager();
        $this->listeners[] = $sharedEvents->attach('ZendCart\Service\Cart', CartEvent::EVENT_ADD_ITEM, array($this, 'onAddItem'));
        $this->listeners[] = $sharedEvents->attach('ZendCart\Service\Cart', CartEvent::EVENT_ADD_ITEM_POST, array($this, 'onAddItemPost'));
        $this->listeners[] = $sharedEvents->attach('ZendCart\Service\Cart', CartEvent::EVENT_REMOVE_ITEM, array($this, 'onRemoveItem'));
        $this->listeners[] = $sharedEvents->attach('ZendCart\Service\Cart', CartEvent::EVENT_REMOVE_ITEM_POST, array($this, 'onRemoveItemPost'));
        $this->listeners[] = $sharedEvents->attach('ZendCart\Service\Cart', CartEvent::EVENT_CREATE_CART, array($this, 'onCreateCart'));
        $this->listeners[] = $sharedEvents->attach('ZendCart\Service\Cart', CartEvent::EVENT_CREATE_CART_POST, array($this, 'onCreateCartPost'));
        $this->listeners[] = $sharedEvents->attach('ZendCart\Service\Cart', CartEvent::EVENT_DELETE_CART, array($this, 'onDeleteCart'));
        $this->listeners[] = $sharedEvents->attach('ZendCart\Service\Cart', CartEvent::EVENT_DELETE_CART_POST, array($this, 'onDeleteCartPost'));
        $this->listeners[] = $sharedEvents->attach('ZendCart\Service\Cart', CartEvent::EVENT_EMPTY_CART, array($this, 'onEmptyCart'));
        $this->listeners[] = $sharedEvents->attach('ZendCart\Service\Cart', CartEvent::EVENT_EMPTY_CART_POST, array($this, 'onEmptyCartPost'));
        $this->listeners[] = $sharedEvents->attach('ZendCart\Service\Cart', CartEvent::EVENT_UPDATE_QUANTITY, array($this, 'onUpdateQuantity'));
        $this->listeners[] = $sharedEvents->attach('ZendCart\Service\Cart', CartEvent::EVENT_UPDATE_QUANTITY_POST, array($this, 'onUpdateQuantityPost'));
    }

    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }

    public function onAddItem(CartEvent $e)
    {
        $this->getLogger()->debug(__CLASS__.'::'.__FUNCTION__.'('.__LINE__.')');

    }

    public function onAddItemPost(CartEvent $e)
    {
        $this->getLogger()->debug(__CLASS__.'::'.__FUNCTION__.'('.__LINE__.')');
        $cartId = $e->getCartId();
        $item = $e->getCartItem();
        $itemToken = $e->getItemToken();

        $item['itemToken'] = $itemToken;

        $cartItem = new CartItem($item);
        $this->cartService->addItemToCart($cartItem, $cartId);
    }

    public function onRemoveItem(CartEvent $e)
    {
        $this->getLogger()->debug(__CLASS__.'::'.__FUNCTION__.'('.__LINE__.')');

    }

    public function onRemoveItemPost(CartEvent $e)
    {
        $this->getLogger()->debug(__CLASS__.'::'.__FUNCTION__.'('.__LINE__.')');
        $cartId = $e->getCartId();
        $itemToken = $e->getItemToken();

        //recuper item tramite cartid e itemtoken
        $this->cartService->removeCartItem($cartId, $itemToken);

    }

    public function onCreateCart(Event $e)
    {
        $this->getLogger()->debug(__CLASS__.'::'.__FUNCTION__.'('.__LINE__.')');
    }

    public function onCreateCartPost(Event $e)
    {
        $this->getLogger()->debug(__CLASS__.'::'.__FUNCTION__.'('.__LINE__.')');
        $cartId = $e->getParam('cart_id');
        //check if exist
        $cart = $this->cartService->findById($cartId);
        if(!$cart){
            $cart = new Cart($cartId);
        }
        $this->cartService->persist($cart);
    }

    public function onDeleteCart(Event $e)
    {
        $this->getLogger()->debug(__CLASS__.'::'.__FUNCTION__.'('.__LINE__.')');

    }

    public function onDeleteCartPost(Event $e)
    {
        $this->getLogger()->debug(__CLASS__.'::'.__FUNCTION__.'('.__LINE__.')');
        $this->cartService->deleteCart($e->getParam('cart_id'));
    }

    public function onEmptyCart(Event $e)
    {
        $this->getLogger()->debug(__CLASS__.'::'.__FUNCTION__.'('.__LINE__.')');

    }

    public function onEmptyCartPost(Event $e)
    {
        $this->getLogger()->debug(__CLASS__.'::'.__FUNCTION__.'('.__LINE__.')');

    }

    public function onUpdateQuantity(CartEvent $e)
    {
        $this->getLogger()->debug(__CLASS__.'::'.__FUNCTION__.'('.__LINE__.')');
    }

    public function onUpdateQuantityPost(CartEvent $e)
    {
        $this->getLogger()->debug(__CLASS__.'::'.__FUNCTION__.'('.__LINE__.')');
        $cartId = $e->getCartId();
        $itemToken = $e->getItemToken();
        $data = $e->getCartItem();
        //recuper item tramite cartid e itemtoken
        $cartItem = $this->cartService->findItemBy($cartId, $itemToken);
        if($cartItem){
            $this->cartService->getHydrator()->hydrate($data, $cartItem);
            $this->cartService->updateCartItem($cartItem);
        }
//        throw new \Exception("No cart item found for cartId: $cartId and token: $itemToken");

    }

    /**
     * Gets the value of logger.
     *
     * @return mixed
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * Sets the value of logger.
     *
     * @param mixed $logger the logger
     *
     * @return self
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;

        return $this;
    }
}
