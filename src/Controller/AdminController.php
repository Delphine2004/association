<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Entity\User;
use App\Enum\UserRole;
use App\Form\UserType;
use App\Service\MongoNewsletterService;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
final class AdminController extends AbstractController
{

    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    #[Route('/dashboard', name: 'admin_dashboard', methods: ['GET'])]
    public function adminAccount(
        UserRepository $userRepository
    ): Response {
        // Récupération des utilisateurs
        $users = $userRepository->findUsersWithoutRole(UserRole::ADMIN->value);

        return $this->render('admin/index.html.twig', [
            'users' => $users,
        ]);
    }

    // Pas de vérification du token car fait avec le formType
    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $user = new User();
        $form = $this->createForm(UserType::class, $user, ['mode' => 'create']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('password')->getData();
            $role = $form->get('role')->getData();

            $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);

            $user->setPassword($hashedPassword);
            $user->setRoles($role ? [$role->value] : []);

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Utilisateur créé avec succès.');
            return $this->redirectToRoute('app_user_show', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        User $user,
        EntityManagerInterface $entityManager,
        Security $security
    ): Response {


        $currentUser = $security->getUser();

        if ($currentUser === $user) {
            throw $this->createAccessDeniedException(
                'Vous ne pouvez pas supprimer votre propre compte.'
            );
        }

        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
            $this->addFlash('success', 'Utilisateur supprimé avec succès.');
        } else {
            $this->addFlash('error', 'Jeton CSRF invalide.');
        }

        return $this->redirectToRoute('admin_dashboard', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/newsletter/emails', name: 'admin_newsletter_emails')]
    public function listEmails(
        MongoNewsletterService $newsletterService
    ): Response {
        $emails = $newsletterService->getAllEmails();

        return $this->render('admin/newsletter_emails.html.twig', [
            'emails' => $emails,
        ]);
    }
}
