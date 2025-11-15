<?php

namespace App\Form;

use App\Entity\Animal;
use App\Enum\AnimalCategory;
use App\Enum\AnimalRace;
use App\Enum\AnimalGender;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
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
            ])
            ->add('birthday', DateType::class, [
                'label' => 'Date de naissance',
                'required' => false,
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

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animal::class,
        ]);
    }
}
