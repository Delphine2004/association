<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\Specification;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('type')
            ->add('race')
            ->add('gender')
            ->add('status')
            ->add('vaccinated')
            ->add('sterilized')
            ->add('chipped')
            ->add('compatibleKid')
            ->add('compatibleCat')
            ->add('compatibleDog')
            ->add('birthday')
            ->add('arrivalDate')
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('updatedAt', null, [
                'widget' => 'single_text',
            ])
            ->add('specifications', EntityType::class, [
                'class' => Specification::class,
                'choice_label' => 'id',
                'multiple' => true,
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
