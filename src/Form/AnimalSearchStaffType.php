<?php

namespace App\Form;

use App\Entity\Animal;
use App\Enum\AnimalCategory;
use App\Enum\AnimalRace;
use App\Enum\AnimalGender;
use App\Enum\AdoptionStatus;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalSearchStaffType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', EnumType::class, [
                'class' => AnimalCategory::class,
                'label' => 'Type',
                'choice_label' => fn(AnimalCategory $choice) => $choice->value,
                'placeholder' => 'Choisir un type',
                'required' => false,
                'attr' => [
                    'class' => 'form-select',
                ],
            ])
            ->add('race', EnumType::class, [
                'class' => AnimalRace::class,
                'label' => 'Race',
                'choice_label' => fn(AnimalRace $choice) => $choice->value,
                'placeholder' => 'Choisir une race',
                'required' => false,
                'attr' => [
                    'class' => 'form-select',
                ],
            ])
            ->add('gender', EnumType::class, [
                'class' => AnimalGender::class,
                'label' => 'Genre',
                'choice_label' => fn(AnimalGender $choice) => $choice->value,
                'placeholder' => 'Choisir un genre',
                'required' => false,
                'attr' => [
                    'class' => 'form-select',
                ],
            ])
            ->add('status', EnumType::class, [
                'class' => AdoptionStatus::class,
                'label' => 'Statut',
                'choice_label' => fn(AdoptionStatus $choice) => $choice->value,
                'placeholder' => 'Choisir un statut',
                'required' => false,
                'attr' => [
                    'class' => 'form-select',
                ],
            ])
            ->add('notSterilized', CheckboxType::class, [
                'label' => 'Pas stérilisé(e)',
                'required' => false,
                'mapped' => false,
                'attr' => [
                    'class' => 'form-check-input',
                ],
            ])
            ->add('notVaccinated', CheckboxType::class, [
                'label' => 'Pas vacciné(e)',
                'required' => false,
                'mapped' => false,
                'attr' => [
                    'class' => 'form-check-input',
                ],
            ])
            ->add('arrivalDate', DateType::class, [
                'label' => 'Date d\'arrivée',
                'placeholder' => 'JJ/MM/AAAA',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
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
