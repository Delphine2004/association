<?php

namespace App\Form;

use App\Enum\AnimalCategory;
use App\Enum\AnimalRace;
use App\Enum\AnimalGender;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class AnimalSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', EnumType::class, [
                'class' => AnimalCategory::class,
                'label' => 'Type',
                'choice_label' => 'name', // Afficher le nom du type
                'placeholder' => 'Choisir un type', // Première option vide
                'required' => false,
                'attr' => [
                    'class' => 'form-select', // class bootstrap
                ],
            ])
            ->add('race', EnumType::class, [
                'class' => AnimalRace::class,
                'label' => 'Race',
                'choice_label' => 'name', // Afficher le nom du type
                'placeholder' => 'Choisir une race', // Première option vide

                'required' => false,
                'attr' => [
                    'class' => 'form-select',
                ],
            ])
            ->add('gender', EnumType::class, [
                'class' => AnimalGender::class,
                'label' => 'Genre',
                'choice_label' => 'name', // Afficher le nom du type
                'placeholder' => 'Choisir un genre', // Première option vide

                'required' => false,
                'attr' => [
                    'class' => 'form-select',
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Détacher le formulaire de l'entité
            'data_class' => null,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }
}
