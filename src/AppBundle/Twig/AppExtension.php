<?php

namespace AppBundle\Twig;

use AppBundle\Entity\Product;
use AppBundle\Entity\Pack;
use AppBundle\Entity\ProductPack;

use AppBundle\Service\PlatformService;

use Twig\Extension\AbstractExtension;

use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
	public function __construct(
        PlatformService $platformService
    ) {
        $this->platformService = $platformService;
    }
	
    public function getFilters()
    {
        return [
            new TwigFilter('countProducts', [$this, 'countProductsPack']),
        ];
    }

	public function getFunctions()
    {
        return array(
            new TwigFunction('getPacksHavingProduct', array($this, 'getPacksHavingProduct')),
            new TwigFunction('getFirstProductPackHavingProduct', array($this, 'getFirstProductPackHavingProduct')),
        );
    }
	
    public function countProductsPack(Pack $pack)
    {
        return $this->platformService->countProductsPack($pack);
    }
	
    public function getPacksHavingProduct(Product $product)
    {
        return $this->platformService->getPacksHavingProduct($product);
    }
	
    public function getFirstProductPackHavingProduct(Product $product)
    {
        return $this->platformService->getFirstProductPackHavingProduct($product);
    }
}