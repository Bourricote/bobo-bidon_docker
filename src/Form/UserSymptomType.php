<?php

namespace App\Form;

use App\Entity\Symptom;
use App\Entity\UserSymptom;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserSymptomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $thisYear = getDate()['year'];
        $nextYear = ( $thisYear + 1 );

        $builder
            ->add('time', TimeType::class, [
                'label' => 'Heure',
                'minutes' => [
                    00, 15, 30, 45,
                ]
            ])
            ->add('date', DateType::class, [
                'years' => [
                    $thisYear, $nextYear,
                ]
            ])
            ->add('symptom', EntityType::class, [
                'label' => 'Symptômes',
                'class' => Symptom::class,
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => false,
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserSymptom::class,
        ]);
    }
}
