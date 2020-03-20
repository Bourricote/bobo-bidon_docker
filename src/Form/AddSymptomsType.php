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
        $thisYear = getDate()['year'];
        $nextYear = ( $thisYear + 1 );

        $builder
            ->add('time', TimeType::class, [
                'minutes' => [
                    00, 15, 30, 45,
                ]
            ])
            ->add('date', DateType::class, [
                'years' => [
                    $thisYear, $nextYear,
                ]
            ])
            ->add('symptoms', EntityType::class, [
                'class' => Symptom::class,
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => true,
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
