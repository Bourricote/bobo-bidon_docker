<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Food;
use App\Repository\FoodRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddFoodsType extends AbstractType
{
    private $foodRepository;

    public function __construct(FoodRepository $foodRepository)
    {
        $this->foodRepository = $foodRepository;
    }

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
            ])
            ->add('foods', CollectionType::class, [
                'label' => false,
                'entry_type' => FoodListType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
            ]);;

        $formModifier = function (FormInterface $form, FoodRepository $foodRepository, Category $category = null) {
            $foods = null === $category ? $foodRepository->findBy([], ['name' => 'ASC']) : $category->getFoods();

            $form->add('food', EntityType::class, [
                'label'        => ' ',
                'class'        => Food::class,
                'placeholder'  => '',
                'choice_label' => 'name',
                'choices'      => $foods,
                'mapped'       => false,
            ]);
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                $data = $event->getData();
                $formModifier($event->getForm(), $this->foodRepository, $data['category']);
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
                $formModifier($event->getForm()->getParent(), $this->foodRepository, $category);
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
