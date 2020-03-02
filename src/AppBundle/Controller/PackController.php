<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Entity\Brand;
use AppBundle\Entity\Pack;
use AppBundle\Entity\ProductPack;
use AppBundle\Form\ProductType;
use AppBundle\Form\PackType;
use AppBundle\Form\ProductPackType;

use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Repository\ProductRepository;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PackController extends Controller
{
	public function __construct( )
    {
        //$this->productRepository = $this->getDoctrine()->getRepository(Product::class);
    }
	
    /**
     * @Route("/packs", name="packs")
     */
    public function packsAction(Request $request)
    {
		$packs = $this->getDoctrine()
        ->getRepository(Pack::class)
        ->findAll();
        return $this->render('pack/packs.html.twig', [
            'packs' => $packs,
        ]);
    }
	
    /**
     * @Route("/pack/{id}", name="pack_view")
	 * @ParamConverter("pack", class="AppBundle:Pack")
     */
    public function viewPackAction(Request $request, Pack $pack)
    {
		$productPacks = $this->getDoctrine()
        ->getRepository(ProductPack::class)
        ->findBy(array(
			'pack' => $pack,
		));
		
		$productPack = new ProductPack();
		$productPack->setPack($pack);
		$productPack->setQuantity(1);
		$form = $this->get('form.factory')->createNamed('name', ProductPackType::class, $productPack);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$productPackTmp = $this->getDoctrine()
			->getRepository(ProductPack::class)
			->findOneBy(array(
				'pack' => $pack,
				'product' => $productPack->getProduct(),
			));
			if(!$productPackTmp){
				if($productPack->getQuantity() <= 0){
					$this->addFlash(
						'warning',
						'Veuillez indiquer une quantité positive pour ce produit.'
					);
				}else{
					$em->persist($productPack);
					$em->flush();
					$this->addFlash(
						'success',
						'Intervention faite avec succès.'
					);
				}
			}else{
				$diff = $productPackTmp->getQuantity() + $productPack->getQuantity();
				if($diff == 0){
					$em->remove($productPackTmp);
					$em->flush();
					$this->addFlash(
						'success',
						'Intervention faite avec succès.'
					);
				}elseif($diff > 0){
					$productPackTmp->setQuantity($diff);
					$em->persist($productPackTmp);
					$em->flush();
					$this->addFlash(
						'success',
						'Intervention faite avec succès.'
					);
				}else{
					$this->addFlash(
						'warning',
						'Veuillez saisir une quantité valable par rapport aux existants.'
					);
				}
			}
			
			return $this->redirectToRoute('pack_view', array(
				'id' => $pack->getId(),
			));
		}
		
        return $this->render('pack/pack.html.twig', [
            'pack' => $pack,
            'productPacks' => $productPacks,
			'form' => $form->createView(),
        ]);
    }
	
	
	
    /**
     * @Route("/pack-add", name="pack_add")
     */
    public function packAddAction(Request $request)
    {
		$pack = new Pack();
		
		$form = $this->get('form.factory')->createNamed('name', PackType::class, $pack);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			//$pack = $form->getData();
			$em = $this->getDoctrine()->getManager();
			$em->persist($pack);
			$em->flush();
			$this->addFlash(
				'success',
				'Ajout fait avec succès.'
			);
			return $this->redirectToRoute('packs');
		}
		
        return $this->render('pack/pack-add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
