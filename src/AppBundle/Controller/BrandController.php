<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Entity\Brand;
use AppBundle\Form\BrandType;

use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Repository\ProductRepository;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BrandController extends Controller
{
    /**
     * @Route("/brands", name="brands")
     */
    public function brandsAction(Request $request)
    {
		$brands = $this->getDoctrine()
        ->getRepository(Brand::class)
        ->findAll();
        return $this->render('brand/brands.html.twig', [
            'brands' => $brands,
        ]);
    }
	
    /**
     * @Route("/brand/{id}", name="brand_view")
	 * @ParamConverter("brand", class="AppBundle:Brand")
     */
    public function viewBrandAction(Brand $brand)
    {
        return $this->render('brand/brand.html.twig', [
            'brand' => $brand,
        ]);
    }
	
    /**
     * @Route("/brand-add", name="brand_add")
     */
    public function brandAddAction(Request $request)
    {
		$brand = new Brand();
		
		$form = $this->get('form.factory')->createNamed('name', BrandType::class, $brand);
		
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			//$brand = $form->getData();
			$em = $this->getDoctrine()->getManager();
			$em->persist($brand);
			$em->flush();
			$this->addFlash(
				'success',
				'Ajout fait avec succès.'
			);
			return $this->redirectToRoute('brands');
		}
		
        return $this->render('brand/brand-add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
	
    /**
     * @Route("/brand-edit/{id}", name="brand_edit")
	 * @ParamConverter("brand", class="AppBundle:Brand")
     */
    public function brandEditAction(Request $request, Brand $brand)
    {
		$form = $this->get('form.factory')->createNamed('name', BrandType::class, $brand);
		
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			//$brand = $form->getData();
			$em = $this->getDoctrine()->getManager();
			$em->persist($brand);
			$em->flush();
			$this->addFlash(
				'success',
				'Modification faite avec succès.'
			);
			return $this->redirectToRoute('brands');
		}
		
        return $this->render('brand/brand-edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
	
    /**
     * @Route("/brand-delete/{id}", name="brand_delete")
	 * @ParamConverter("brand", class="AppBundle:Brand")
     */
    public function brandDeleteAction(Request $request, Brand $brand)
    {
		$em = $this->getDoctrine()->getManager();
		$em->remove($brand);
		$em->flush();
		$this->addFlash(
			'success',
			'Suppression faite avec succès.'
		);
		return $this->redirectToRoute('brands');
    }
}
