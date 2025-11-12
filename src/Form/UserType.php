<?php

namespace App\Form;

use App\Entity\User;
use App\Enum\UserRole;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Adresse e-mail',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'exemple@domaine.com'
                ],
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Mot de passe sécurisé'
                ],
            ])
            /*
            ->add('passwordConfirm', PasswordType::class, [
                'label' => 'Confirmer le mot de passe',

                'mapped' => false, // important : ne correspond pas à une propriété de l’entité
                'attr' => ['class' => 'form-control', 'placeholder' => 'Vérification du mot de passe',],
            ])*/;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
