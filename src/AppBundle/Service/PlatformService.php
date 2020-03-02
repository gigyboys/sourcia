<?php

namespace AppBundle\Service;

use AppBundle\Entity\Pack;
use AppBundle\Entity\Product;
use AppBundle\Entity\ProductPack;
use AppBundle\Repository\ProductPackRepository;
use Doctrine\ORM\EntityManagerInterface;

class PlatformService
{
	public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }
	
    public function getRandomMessage()
    {
        $messages = [
            'Message 1',
            'Message 2',
            'Message 3',
            'Message 4',
            'Message 5',
        ];

        $index = array_rand($messages);

        return $messages[$index];
    }
	
    public function countProductsPack(Pack $pack)
    {
		$quantity = 0;
		$productPacks = $this->em->getRepository(ProductPack::class)
		->findBy(array(
			'pack' => $pack,
		));
		
		foreach($productPacks as $productPack){
            $quantity += $productPack->getQuantity();
        }
		
        return $quantity;
    }
	
    public function getPacksHavingProduct(Product $product)
    {
		$productPacks = $this->em->getRepository(ProductPack::class)
		->getProductPacksHavingProduct($product);
		
		$packs = array();
		foreach($productPacks as $productPack){
            $packs[] = $productPack->getPack();
        }
		
        return $packs;
    }
	
    public function getFirstProductPackHavingProduct(Product $product)
    {
		$productPack = $this->em->getRepository(ProductPack::class)
		->getFirstProductPackHavingProduct($product);
		
        return $productPack;
    }
}
