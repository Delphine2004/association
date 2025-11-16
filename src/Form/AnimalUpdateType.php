<?php

namespace App\Form;

use App\Entity\Animal;
use App\Enum\AdoptionStatus;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
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
