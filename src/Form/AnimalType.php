<?php

namespace App\Form;

use App\Entity\Animal;
use App\Enum\AnimalCategory;
use App\Enum\AnimalRace;
use App\Enum\AnimalGender;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
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
                'attr' => ['class' => 'form-select',],
            ])
            ->add('type', EnumType::class, [
                'class' => AnimalCategory::class,
                'label' => 'Type',
                'choice_label' => 'name',
                'placeholder' => 'Choisir un type',
                'required' => true,
                'attr' => ['class' => 'form-select',],
            ])
            ->add('race', EnumType::class, [
                'class' => AnimalRace::class,
                'label' => 'Race',
                'choice_label' => 'name',
                'placeholder' => 'Choisir une race',
                'required' => true,
                'attr' => ['class' => 'form-select',],
            ])
            ->add('gender', EnumType::class, [
                'class' => AnimalGender::class,
                'label' => 'Genre',
                'choice_label' => 'name',
                'placeholder' => 'Choisir un genre',
                'required' => true,
                'attr' => ['class' => 'form-select',],
            ])
            ->add('birthday', BirthdayType::class, [
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
                'required' => false,
                'attr' => ['class' => 'form-select',],
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
