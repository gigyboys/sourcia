<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Entity\Brand;
use AppBundle\Form\ProductType;

use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Repository\ProductRepository;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends Controller
{
	public function __construct( )
    {
        //$this->productRepository = $this->getDoctrine()->getRepository(Product::class);
    }
	
    /**
     * @Route("/products", name="products")
     */
    public function productsAction(Request $request)
    {
		//$products = $this->productRepository->findAll();
		$products = $this->getDoctrine()
        ->getRepository(Product::class)
        ->findAll();
        return $this->render('product/products.html.twig', [
            'products' => $products,
        ]);
    }
	
    /**
     * @Route("/product/{id}", name="product_view")
	 * @ParamConverter("product", class="AppBundle:Product")
     */
    public function viewProductAction(Product $product)
    {
        return $this->render('product/product.html.twig', [
            'product' => $product,
        ]);
    }
	
	
	
    /**
     * @Route("/product-add", name="product_add")
     */
    public function productAddAction(Request $request)
    {
		$product = new Product();
		
		$form = $this->get('form.factory')->createNamed('name', ProductType::class, $product);
		
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			//$product = $form->getData();
			$em = $this->getDoctrine()->getManager();
			$em->persist($product);
			$em->flush();
			$this->addFlash(
				'success',
				'Ajout fait avec succès.'
			);
			return $this->redirectToRoute('products');
		}
		
        return $this->render('product/product-add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
	
    /**
     * @Route("/product-edit/{id}", name="product_edit")
	 * @ParamConverter("product", class="AppBundle:Product")
     */
    public function productEditAction(Request $request, Product $product)
    {
		$form = $this->get('form.factory')->createNamed('name', ProductType::class, $product);
		
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			//$product = $form->getData();
			$em = $this->getDoctrine()->getManager();
			$em->persist($product);
			$em->flush();
			$this->addFlash(
				'success',
				'Modification faite avec succès.'
			);
			return $this->redirectToRoute('products');
		}
		
        return $this->render('product/product-edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
