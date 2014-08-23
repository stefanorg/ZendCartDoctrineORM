<?php
namespace ZendCartDoctrineORM\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="_cart")
 */
class Cart implements CartEntityInterface{

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     */
    protected $id;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     * @var date
     */
    protected $created;
    
    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     * @var date
     */
    protected $updated;

    /**
     * @ORM\OneToMany(targetEntity="CartItem", mappedBy="cart", cascade={"remove"})
     */
    protected $items;


    function __construct($id){
        $this->id = $id;
        $this->items = new ArrayCollection();
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
     * Gets the value of items.
     *
     * @return mixed
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Sets the value of items.
     *
     * @param mixed $items the items
     *
     * @return self
     */
    public function setItems($items)
    {
        $this->items = $items;

        return $this;
    }

    /**
     * Gets the value of created.
     *
     * @return date
     */
    public function getCreated()
    {
        return $this->created;
    }
    
    /**
     * Sets the value of created.
     *
     * @param date $created the created 
     *
     * @return self
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Gets the value of updated.
     *
     * @return date
     */
    public function getUpdated()
    {
        return $this->updated;
    }
    
    /**
     * Sets the value of updated.
     *
     * @param date $updated the updated 
     *
     * @return self
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }
}