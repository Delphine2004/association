<?php

namespace App\Form;

use App\Entity\Animal;
use App\Enum\AnimalCategory;
use App\Enum\AnimalRace;
use App\Enum\AnimalGender;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\File;

use Symfony\Component\OptionsResolver\OptionsResolver;


class AnimalType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $mode = $options['mode'];

        if ($mode === 'create') {
            $builder
                ->add('name', TextType::class, [
                    'label' => 'Nom de l\'animal',
                    'required' => true,
                ])
                ->add('type', EnumType::class, [
                    'class' => AnimalCategory::class,
                    'label' => 'Type',
                    'choice_label' => fn(AnimalCategory $choice) =>  $choice->value,
                    'required' => true,
                ])
                ->add('race', EnumType::class, [
                    'class' => AnimalRace::class,
                    'label' => 'Race',
                    'choice_label' => fn(AnimalRace $choice) => $choice->value,
                    'required' => true,
                ])
                ->add('gender', EnumType::class, [
                    'class' => AnimalGender::class,
                    'label' => 'Genre',
                    'choice_label' => fn(AnimalGender $choice) => $choice->value,
                    'required' => true,
                ])
                ->add('picture', FileType::class, [
                    'label' => 'Photo',
                    'mapped' => false,
                    'required' => true,
                    'constraints' => [
                        new File(
                            maxSize: '10M',
                            mimeTypes: [
                                'image/jpeg',
                                'image/png',
                                'image/webp',
                            ],
                            mimeTypesMessage: 'Merci d’uploader une image valide (jpeg, png, webp)',
                        )
                    ],

                ])
                ->add('birthday', DateType::class, [
                    'label' => 'Date de naissance',
                    'required' => true,
                    'empty_data' => null,
                    'input' => 'datetime',
                    'widget' => 'single_text',
                    'html5' => true,
                ])
                ->add('arrivalDate', DateType::class, [
                    'label' => 'Date d\'arrivée',
                    'required' => true,
                    'widget' => 'single_text',
                    'html5' => true,
                ])
                ->add('description', TextareaType::class, [
                    'label' => 'Description de l\'animal',
                    'required' => true,
                ])
            ;
        }

        if ($mode === 'update') {
            $builder
                ->add('picture', FileType::class, [
                    'label' => 'Photo',
                    'mapped' => false,
                    'required' => false,
                ])
                ->add('vaccinated', CheckboxType::class, [
                    'label' => 'Vacciné(e)',
                    'required' => false,
                ])
                ->add('sterilized', CheckboxType::class, [
                    'label' => 'Stérilisé(e)',
                    'required' => false,
                ])
                ->add('chipped', CheckboxType::class, [
                    'label' => 'Pucé(e)',
                    'required' => false,
                ])
                ->add('compatibleKid', CheckboxType::class, [
                    'label' => 'Compatible Enfants',
                    'required' => false,
                ])
                ->add('compatibleCat', CheckboxType::class, [
                    'label' => 'Compatible Chats',
                    'required' => false,
                ])
                ->add('compatibleDog', CheckboxType::class, [
                    'label' => 'Compatible Chiens',
                    'required' => false,
                ])
                ->add('description', TextareaType::class, [
                    'label' => 'Description de l\'animal',
                    'required' => false,
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
