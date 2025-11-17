<?php

namespace App\Form;

use App\Entity\User;
use App\Enum\UserRole;
use App\Utils\RegexPatterns;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserAdminType extends AbstractType
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
                'required' => true,
                'mapped' => false, // n'est pas mappé avec la bd car il sera hashé
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Mot de passe sécurisé',
                ],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le mot de passe est obligatoire.']),
                    new Assert\Length([
                        'min' => 8,
                        'max' => 255,
                        'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le mot de passe ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                    new Assert\Regex([
                        'pattern' => RegexPatterns::PASSWORD,
                        'message' => 'Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et un caractère spécial.',
                    ]),
                    new Assert\PasswordStrength([
                        'minScore' => Assert\PasswordStrength::STRENGTH_MEDIUM,
                    ]),
                ],
            ])
            ->add('role', EnumType::class, [
                'class' => UserRole::class,
                'label' => 'Rôle',
                'choices' => array_reduce(UserRole::cases(), function ($carry, UserRole $role) {
                    if ($role !== UserRole::ADMIN) {
                        $carry[$role->value] = $role;
                    }
                    return $carry;
                }, []), // Récupère toutes les valeurs de l'Enum et filtre le rôle admin
                'choice_label' => fn(UserRole $choice) => $choice->name,
                'placeholder' => 'Choisir un rôle', // Première option vide
                'required' => false,
                'mapped' => false,
                'attr' => [
                    'class' => 'form-select',
                ],
            ]);

        /*
            ->add('passwordConfirm', PasswordType::class, [
                'label' => 'Confirmer le mot de passe',

                'mapped' => false, // important : ne correspond pas à une propriété de l’entité
                'attr' => ['class' => 'form-control', 'placeholder' => 'Vérification du mot de passe',],
            ])*/
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
