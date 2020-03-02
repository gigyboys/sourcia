<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductPack
 *
 * @ORM\Table(name="product_pack")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductPackRepository")
 */
class ProductPack
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
    * @ORM\ManyToOne(targetEntity=Product::class)
    */
    protected $product;

    /**
    * @ORM\ManyToOne(targetEntity=Pack::class)
    */
    protected $pack;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;
	
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set product
     *
     * @param string $product
     *
     * @return ProductPack
     */
    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return string
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set pack
     *
     * @param string $pack
     *
     * @return ProductPack
     */
    public function setPack($pack)
    {
        $this->pack = $pack;

        return $this;
    }

    /**
     * Get pack
     *
     * @return string
     */
    public function getPack()
    {
        return $this->pack;
    }

    /**
     * Set quantity
     *
     * @param string $quantity
     *
     * @return ProductPack
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return string
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
}

