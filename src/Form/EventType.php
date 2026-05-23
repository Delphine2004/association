<?php

namespace App\Form;

use App\Entity\Event;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $mode = $options['mode'];

        if ($mode === 'create') {
            $builder
                ->add('date', DateType::class, [
                    'label' => 'Date de l\'événement',
                    'required' => true,
                ])
                ->add('place', TextType::class, [
                    'label' => 'Localisation de l\'événement',
                    'required' => true,
                ])
                ->add('description', TextareaType::class, [
                    'label' => 'Description de l\'événement',
                    'required' => true,
                ])
                ->add('picture', FileType::class, [
                    'label' => 'Photo',
                    'mapped' => false,
                    'required' => true,
                    'constraints' => [
                        new File(
                            maxSize: '10M', // ICI tu règles la taille
                            mimeTypes: [
                                'image/jpeg',
                                'image/png',
                                'image/webp',
                            ],
                            mimeTypesMessage: 'Merci d’uploader une image valide (jpeg, png, webp)',
                        )
                    ],
                ])
            ;
        }

        if ($mode === 'update') {
            $builder
                ->add('date', DateType::class, [
                    'label' => 'Date de l\'événement',
                    'required' => false,
                    'widget' => 'single_text',
                    'html5' => true,
                ])
                ->add('place', TextType::class, [
                    'label' => 'Localisation de l\'événement',
                    'required' => false,
                ])
                ->add('description', TextareaType::class, [
                    'label' => 'Description de l\'événement',
                    'required' => false,
                ])
                ->add('picture', FileType::class, [
                    'label' => 'Photo',
                    'mapped' => false,
                    'required' => false,
                    'constraints' => [
                        new File(
                            maxSize: '10M', // ICI tu règles la taille
                            mimeTypes: [
                                'image/jpeg',
                                'image/png',
                                'image/webp',
                            ],
                            mimeTypesMessage: 'Merci d’uploader une image valide (jpeg, png, webp)',
                        )
                    ],
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
            'mode' => 'create', // valeur par défaut
            'csrf_protection' => true,
        ]);
    }
}
