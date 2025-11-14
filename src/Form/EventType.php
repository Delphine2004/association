<?php

namespace App\Form;

use App\Entity\Event;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'label' => 'Date de l\'événement',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => '01/06/2026'
                ],
            ])
            ->add('place', TextType::class, [
                'label' => 'Localisation de l\'événement',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'La forêt'
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description de l\'événement',
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 5,
                    'placeholder' => 'L\'événement va se dérouler ...'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
