<?php
namespace AppBundle\Form;

use AppBundle\Entity\Product;
use AppBundle\Entity\ProductPack;
use AppBundle\Entity\Pack;
use AppBundle\Form\ProductInfoType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class ProductPackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product', EntityType::class, [
				'class' => Product::class,
				'choice_label' => 'name', 
			])
            ->add('quantity')
            ->add('save', SubmitType::class)
        ;
    }
	
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => ProductPack::class,
		]);
	}
}