<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr'  => [
                    'class' => 'form-control mb-2'
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'attr'  => [
                    'class' => 'form-control mb-2'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'attr'  => [
                    'class' => 'form-control mb-2'
                ]
            ])
            ->add('startDate', DateType::class, [
                'widget'    => 'single_text',
                'label'     => 'Date de début de régime ',
                'required'  => false,
                'attr'      => [
                    'class' => ' form-control mb-2'
                ]
            ])
            /*->add('endDate', DateType::class, [
                'widget'    => 'single_text',
                'label'     => 'Date de fin de régime ',
                'required'  => false,
                'attr'      => [
                    'class' => ' form-control mb-2'
                ]
            ])*/
            ->add('age', TextType::class, [
                'label' => 'Age',
                'attr'  => [
                    'class' => 'form-control mb-2'
                ],
                'required'  => false,
            ])
            ->add('weight', TextType::class, [
                'label' => 'Poids en kg',
                'attr'  => [
                    'class' => 'form-control mb-2'
                ],
                'required' => false,
            ])
            ->add('pictureFile', FileType::class, [
                'label' => 'Image de profil',
                'required' => false,
                'attr'  => [
                    'class' => 'form-control mb-2'
                ],
                'constraints' => [
                    new File([
                        'maxSize' => '2000k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Formats de fichier acceptés : Jpeg, Png',
                    ])
                ],
            ])
        ;
        if ($options['admin']) {
            $builder->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux mots de passe doivent être identiques',
                'first_name' => 'Mot_de_passe',
                'second_name' => 'Confirmer_le_mot_de_passe',
                'options' => [
                    'attr' => [
                        'class' => 'form-control mb-2',
                    ]
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de rentrer un mot de passe',
                    ]),
                    new Length([
                        'min'           => 6,
                        'minMessage'    => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max'           => 4096,
                    ]),
                ],
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'admin' => false,
        ]);
    }
}
