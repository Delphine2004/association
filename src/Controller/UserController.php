<?php

namespace App\Controller;


use App\Repository\AnimalRepository;
use App\Repository\EventRepository;
use App\Entity\User;
use App\Enum\AdoptionStatus;
use App\Form\UserType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/user')]
#[IsGranted('ROLE_EMPLOYE')]
final class UserController extends AbstractController
{
    #[Route('/dashboard', name: 'user_dashboard', methods: ['GET'])]
    public function userAccount(
        AnimalRepository $animalRepository,
        EventRepository $eventRepository
    ): Response {

        // Récupération des animaux à examiner
        $animals = $animalRepository->findAnimalsByAdoptionStatus(AdoptionStatus::EN_SOIN);

        // Récupération des évenements à venir
        $events = $eventRepository->findFutureEvents();

        return $this->render('user/index.html.twig', [
            'animals' => $animals,
            'events' => $events,
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        User $user,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ): Response {

        if ($this->isGranted('ROLE_ADMIN')) {
            if ($this->getUser() === $user) {
                $mode = 'updateAdmin';
            } else {
                $mode = 'updateUserByAdmin';
            }
        } else {
            $mode = 'updateUser';
        }

        $form = $this->createForm(UserType::class, $user, ['mode' => $mode]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifie si le mot de passe a été modifié
            if ($form->has('password')) {
                $plainPassword = $form->get('password')->getData();
                if (!empty($plainPassword)) {
                    $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
                    $user->setPassword($hashedPassword);
                }
            }

            // Vérifie si l'email a été modifié pour l'admin
            if ($form->has('email')) {
                $email = $form->get('email')->getData();
                if ($email !== null && $email !== '') {
                    $user->setEmail($email);
                }
            }

            $entityManager->flush();

            $this->addFlash('success', 'Utilisateur modifié avec succès.');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}
