<?php

namespace App\Form;

use App\Entity\Symptom;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddSymptomsType extends AbstractType
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
                    'class' => ' form-control mb-2'
                ]
            ])
            ->add('symptoms', EntityType::class, [
                'label' => ' ',
                'class' => Symptom::class,
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => true,
                'attr' => [
                    'class' => 'd-flex flex-column'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
