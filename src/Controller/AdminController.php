<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Enum\UserRole;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdminController extends AbstractController
{
    #[Route('/admin/dashboard', name: 'admin_dashboard', methods: ['GET'])]
    public function adminAccount(UserRepository $userRepository): Response
    {

        // Récupération des utilisateurs
        $users = $userRepository->findUsersWithoutRole(UserRole::ADMIN->value);

        return $this->render('admin/index.html.twig', [
            'users' => $users,
        ]);
    }
}
