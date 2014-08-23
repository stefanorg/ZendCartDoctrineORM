<?php

namespace ZendCartDoctrineORM\Entity;

use Doctrine\ORM\Mapping as ORM;
use \Datetime;
use Zend\Json\Json;

/**
 * @ORM\Entity
 * @ORM\Table(name="_cart_item")
 */
class CartItem implements CartItemInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * token from zendcart
     * @ORM\Column(name="cart_item_id", type="integer")
     */
    protected $cartItemId;

    /**
     * @ORM\Column(name="qty", type="integer")
     */
    protected $qty;

    /**
     * @ORM\Column(type="text")
     */
    protected $description = "";

    /**
     * @ORM\Column(type="decimal", precision=6, scale=2)
     */
    protected $price;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;

    /**
     * @ORM\Column(type="integer")
     */
    protected $vat;

    /**
     * @ORM\ManyToOne(targetEntity="Cart", inversedBy="items")
     */
    protected $cart;

    /**
     * @ORM\Column(name="item_token")
     */
    protected $itemToken;

    /**
     * @ORM\Column(name="options", type="json_array")
     */
    protected $options;

    public function __construct(array $config = array())
    {
        if (count($config)) {
            $this->cartItemId    = isset($config['id'])          ? $config['id']         : null;
            $this->qty           = isset($config['qty'])         ? $config['qty']        : 0;
            $this->description   = isset($config['description']) ? $config['description']: "";
            $this->price         = isset($config['price'])       ? $config['price']      : null;
            $this->name          = isset($config['name'])        ? $config['name']       : '';
            $this->vat           = isset($config['vat'])         ? $config['vat']        : 0;
            $this->itemToken     = isset($config['itemToken'])   ? $config['itemToken']  : null;

            $this->options       = isset($config['options'])     ? Json::encode($config['options'], false)    : Json::encode(array());
            $this->date          = isset($config['date'])        ? Datetime::createFromFormat('Y-m-d H:i:s', $config['date']) : new Datetime();
        }
    }

    public function getCart()
    {
        return $this->cart;
    }

    public function setCart(CartEntityInterface $cart)
    {
        $this->cart = $cart;

        return $this;
    }

    /**
     * Gets the value of id.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the value of id.
     *
     * @param mixed $id the id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets the value of qty.
     *
     * @return mixed
     */
    public function getQty()
    {
        return $this->qty;
    }

    /**
     * Sets the value of qty.
     *
     * @param mixed $qty the qty
     *
     * @return self
     */
    public function setQty($qty)
    {
        $this->qty = $qty;

        return $this;
    }

    /**
     * Gets the value of description.
     *
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the value of description.
     *
     * @param mixed $description the description
     *
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Gets the value of price.
     *
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Sets the value of price.
     *
     * @param mixed $price the price
     *
     * @return self
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Gets the value of name.
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the value of name.
     *
     * @param mixed $name the name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets the value of options.
     *
     * @return mixed
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Sets the value of options.
     *
     * @param mixed $options the options
     *
     * @return self
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Gets the value of date.
     *
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Sets the value of date.
     *
     * @param mixed $date the date
     *
     * @return self
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Gets the value of vat.
     *
     * @return mixed
     */
    public function getVat()
    {
        return $this->vat;
    }

    /**
     * Sets the value of vat.
     *
     * @param mixed $vat the vat
     *
     * @return self
     */
    public function setVat($vat)
    {
        $this->vat = $vat;

        return $this;
    }

    /**
     * Gets the value of cartItemId.
     *
     * @return mixed
     */
    public function getCartItemId()
    {
        return $this->cartItemId;
    }

    /**
     * set token
     */
    public function setCartItemId($cartItemId)
    {
        $this->cartItemId = $cartItemId;

        return $this;
    }

    /**
     * Gets the value of itemToken.
     *
     * @return mixed
     */
    public function getItemToken()
    {
        return $this->itemToken;
    }

    /**
     * Sets the value of itemToken.
     *
     * @param mixed $itemToken the item token
     *
     * @return self
     */
    public function setItemToken($itemToken)
    {
        $this->itemToken = $itemToken;

        return $this;
    }
}