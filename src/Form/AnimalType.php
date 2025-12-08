<?php

namespace App\Form;

use App\Entity\Animal;
use App\Enum\AdoptionStatus;
use App\Enum\AnimalCategory;
use App\Enum\AnimalRace;
use App\Enum\AnimalGender;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\File;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\Options;

class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $mode = $options['mode'];

        if ($mode === 'create') {
            $builder
                ->add('name', TextType::class, [
                    'label' => 'Nom de l\'animal',
                    'required' => true,
                    'attr' => ['class' => 'form-control',],
                ])
                ->add('type', EnumType::class, [
                    'class' => AnimalCategory::class,
                    'label' => 'Type',
                    'choice_label' => fn(AnimalCategory $choice) =>  $choice->value,
                    'placeholder' => 'Choisir un type',
                    'required' => true,
                    'attr' => ['class' => 'form-select',],
                ])
                ->add('race', EnumType::class, [
                    'class' => AnimalRace::class,
                    'label' => 'Race',
                    'choice_label' => fn(AnimalRace $choice) => $choice->value,
                    'placeholder' => 'Choisir une race',
                    'required' => true,
                    'attr' => ['class' => 'form-select',],
                ])
                ->add('gender', EnumType::class, [
                    'class' => AnimalGender::class,
                    'label' => 'Genre',
                    'choice_label' => fn(AnimalGender $choice) => $choice->value,
                    'placeholder' => 'Choisir un genre',
                    'required' => true,
                    'attr' => ['class' => 'form-select',],
                ])
                ->add('picture', FileType::class, [
                    'label' => 'Photo',
                    'mapped' => false,
                    'required' => true,
                    'attr' => ['class' => 'form-control',],
                    'constraints' => [
                        new File([
                            'maxSize' => '10M', // ICI tu règles la taille
                            'mimeTypes' => [
                                'image/jpeg',
                                'image/png',
                                'image/webp',
                            ],
                            'mimeTypesMessage' => 'Merci d’uploader une image valide (jpeg, png, webp)',
                        ])
                    ],

                ])
                ->add('birthday', DateType::class, [
                    'label' => 'Date de naissance',
                    'required' => true,
                    'empty_data' => null,
                    'input' => 'datetime',
                    'widget' => 'single_text',
                    'html5' => true,
                    'attr' => ['class' => 'form-control',],
                ])
                ->add('arrivalDate', DateType::class, [
                    'label' => 'Date d\'arrivée',
                    'required' => true,
                    'widget' => 'single_text',
                    'html5' => true,
                    'attr' => ['class' => 'form-control',],
                ])
                ->add('description', TextareaType::class, [
                    'label' => 'Description de l\'animal',
                    'required' => true,
                    'attr' => ['class' => 'form-control',],
                ])
            ;
        }

        if ($mode === 'update') {
            $builder
                ->add('picture', FileType::class, [
                    'label' => 'Photo',
                    'mapped' => false,
                    'required' => false,
                    'attr' => ['class' => 'form-control',],
                ])
                ->add('vaccinated', CheckboxType::class, [
                    'label' => 'Vacciné(e)',
                    'required' => false,
                    'attr' => [
                        'class' => 'form-check-input',
                    ],
                ])
                ->add('sterilized', CheckboxType::class, [
                    'label' => 'Stérilisé(e)',
                    'required' => false,
                    'attr' => [
                        'class' => 'form-check-input',
                    ],
                ])
                ->add('chipped', CheckboxType::class, [
                    'label' => 'Pucé(e)',
                    'required' => false,
                    'attr' => [
                        'class' => 'form-check-input',
                    ],
                ])
                ->add('compatibleKid', CheckboxType::class, [
                    'label' => 'Compatible Enfants',
                    'required' => false,
                    'attr' => [
                        'class' => 'form-check-input',
                    ],
                ])
                ->add('compatibleCat', CheckboxType::class, [
                    'label' => 'Compatible Chats',
                    'required' => false,
                    'attr' => [
                        'class' => 'form-check-input',
                    ],
                ])
                ->add('compatibleDog', CheckboxType::class, [
                    'label' => 'Compatible Chiens',
                    'required' => false,
                    'attr' => [
                        'class' => 'form-check-input',
                    ],
                ])
                ->add('description', TextareaType::class, [
                    'label' => 'Description de l\'animal',
                    'required' => false,
                    'attr' => ['class' => 'form-control',],
                ])
            ;
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animal::class,
            'mode' => 'create', // valeur par défaut
            'csrf_protection' => true,
        ]);
    }
}
