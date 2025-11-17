<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Enum\UserRole;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail('staff@association.fr');
        $admin->setRoles([
            UserRole::EMPLOYE->value
        ]);
        $hashedPassword = $this->hasher->hashPassword($admin, 'staff123');
        $admin->setPassword($hashedPassword, true);

        $manager->persist($admin);
        $manager->flush();
    }
}
