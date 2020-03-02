<?php
namespace AppBundle\Form;

use AppBundle\Entity\Product;
use AppBundle\Entity\Brand;
use AppBundle\Form\ProductInfoType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('code')
            ->add('price')
            ->add('service', ChoiceType::class, [
				'choices'  => [
					'Non' => false,
					'Oui' => true,
				],
				'expanded' => true,
				'multiple' => false,
			])
			->add('productInfo', productInfoType::class, [
				'label' => 'Informations supplémentaires',
            ])
			->add('brands', EntityType::class, [
                'class' => Brand::class,
                'multiple' => true,
                'expanded' => true,
				'choice_label' => 'name',
				'query_builder' => function (EntityRepository $er) {
					return $er->createQueryBuilder('b')
						->orderBy('b.id', 'DESC');
				},
				'label' => 'Choisissez les marques liées a ce produit',
            ])
            ->add('save', SubmitType::class)
        ;
    }
	
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => Product::class,
		]);
	}
}