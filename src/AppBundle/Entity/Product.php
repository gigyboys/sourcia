<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 */
class Product
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
     * @var boolean
     *
     * @ORM\Column(name="service", type="boolean", options={"default"=0})
     */
    private $service;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255)
     */
    private $code;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;
	
	
	/**
    * @ORM\OneToOne(targetEntity=ProductInfo::class, cascade={"persist", "remove"})
    */
    private $productInfo;

	/**
    * @ORM\ManyToMany(targetEntity=Brand::class, inversedBy="products")
    */
    private $brands;
	
	public function __construct()
    {
        $this->brands = new ArrayCollection();
        $this->setService(false);
    }
	
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function setService($service)
    {
        $this->service = $service;

        return $this;
    }

    public function isService()
    {
        return $this->service;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Product
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set productInfo
     *
     * @param ProductInfo $productInfo
     *
     * @return Product
     */
    public function setProductInfo(ProductInfo $productInfo)
    {
        $this->productInfo = $productInfo;

        return $this;
    }

    /**
     * Get productInfo
     *
     * @return string
     */
    public function ProductInfo()
    {
        return $this->productInfo;
    }

    /**
     * Set brands
     *
     * @param float $brands
     *
     * @return Product
     */
    public function setBrands($brands)
    {
        $this->brands = $brands;

        return $this;
    }

    /**
     * Get brands
     *
     * @return float
     */
    public function getBrands()
    {
        return $this->brands;
    }
}

