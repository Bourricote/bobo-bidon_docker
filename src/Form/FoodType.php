<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Food;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FoodType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr'  => [
                    'class' => 'form-control mb-2'
                ]
            ])
            ->add('isHighFodmap', ChoiceType::class, [
                'label' => 'Niveau en fodmap',
                'choices' => [
                    'Bas' => Food::LOW_FODMAP,
                    'Haut' => Food::HIGH_FODMAP,
                ],
                'attr'  => [
                    'class' => 'mb-2'
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('oligos', NumberType::class, [
                'attr'  => [
                    'class' => 'form-control mb-2'
                ]
            ])
            ->add('fructose', NumberType::class, [
                'attr'  => [
                    'class' => 'form-control mb-2'
                ]
            ])
            ->add('polyols', NumberType::class, [
                'attr'  => [
                    'class' => 'form-control mb-2'
                ]
            ])
            ->add('lactose', NumberType::class, [
                'attr'  => [
                    'class' => 'form-control mb-2'
                ]
            ])
            ->add('category', EntityType::class, [
                'label' => 'Catégorie',
                'class' => Category::class,
                'choice_label' => 'name',
                'expanded' => false,
                'multiple' => false,
                'attr' => [
                    'class' => 'form-control mb-2'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Food::class,
        ]);
    }
}
