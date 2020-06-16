<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Food;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddFoodsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('time', TimeType::class, [
                'label' => 'Heure',
                'minutes' => [
                    00, 15, 30, 45,
                ],
                'attr'      => [
                    'class' => 'mb-2'
                ]
            ])
            ->add('date', DateType::class, [
                'widget'    => 'single_text',
                'attr'      => [
                    'class' => 'form-control mb-2'
                ]
            ])
            ->add('category', EntityType::class, [
                'label'        => ' ',
                'class'        => Category::class,
                'choice_label' => 'name',
                'placeholder'  => 'Sélectionnez une catégorie',
                'mapped'       => false,
                'required'     => false,
                'attr'         => [
                    'class' => 'd-flex flex-column'
                ],
            ]);

        $formModifier = function (FormInterface $form, Category $category = null) {
            $foods = null === $category ? [] : $category->getFoods();

            $form->add('food', EntityType::class, [
                'label'        => ' ',
                'class'        => Food::class,
                'placeholder'  => '',
                'choice_label' => 'name',
                'choices'      => $foods,
            ]);
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                // this would be your entity, i.e. SportMeetup
                $data = $event->getData();
                $formModifier($event->getForm(), $data['category']);
            }
        );

        $builder->get('category')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $category = $event->getForm()->getData();

                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback functions!
                $formModifier($event->getForm()->getParent(), $category);
            }
        );
    }

    private function addFoodField(FormInterface $form, ?Category $category)
    {
        $form->add(
            'food',
            EntityType::class,

            [
                'label'           => ' ',
                'placeholder'     => $category ? 'Sélectionnez un aliment' : 'Sélectionnez une catégorie',
                'class'           => Food::class,
                'choice_label'    => 'name',
                'auto_initialize' => false,
                'choices'         => $category ? $category->getFoods() : [],
                'attr'            => [
                    'class' => 'd-flex flex-column'
                ],
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
