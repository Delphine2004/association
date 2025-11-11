<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\Specification;

use App\Enum\AnimalType;
use App\Enum\AnimalRace;
use App\Enum\AnimalGender;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class AnimalSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', EnumType::class, [
                'class' => AnimalType::class,
                'choice_label' => 'name', // Afficher le nom du type
                'placeholder' => 'Choisir un type', // Première option vide
                'label' => 'Type',
                'required' => false,
            ])
            ->add('race', EnumType::class, [
                'class' => AnimalRace::class,
                'choice_label' => 'name', // Afficher le nom du type
                'placeholder' => 'Choisir une race', // Première option vide
                'label' => 'Race',
                'required' => false,
            ])
            ->add('gender', EnumType::class, [
                'class' => AnimalGender::class,
                'choice_label' => 'name', // Afficher le nom du type
                'placeholder' => 'Choisir un genre', // Première option vide
                'label' => 'Genre',
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Détacher le formulaire de l'entité Animal ***
            'data_class' => null,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }
}
