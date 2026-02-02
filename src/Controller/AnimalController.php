<?php

namespace App\Controller;


use App\Entity\Animal;
use App\Enum\AdoptionStatus;
use App\Form\AnimalType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/animal')]

final class AnimalController extends AbstractController
{
    public function __construct(private string $uploadsAnimalsDirectory) {}

    #[Route('', name: 'app_animal_page', methods: ['GET'])]
    #[IsGranted('ROLE_EMPLOYE')]
    public function page(): Response
    {
        return $this->render('animal/index.html.twig');
    }

    // Pas de vérification du token car fait avec le formType
    #[Route('/new', name: 'app_animal_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_EMPLOYE')]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $animal = new Animal();
        $form = $this->createForm(AnimalType::class, $animal, ['mode' => 'create']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form->get('picture')->getData();

            if ($uploadedFile) {
                //  Générer un nom unique
                $fileName = uniqid() . '.' . $uploadedFile->guessExtension();
                $uploadedFile->move($this->uploadsAnimalsDirectory, $fileName);
                $animal->setPicture($fileName);
            }

            $animal->setStatus(AdoptionStatus::EN_SOIN);
            $animal->setVaccinated(false);
            $animal->setSterilized(false);
            $animal->setChipped(false);
            $animal->setCompatibleKid(false);
            $animal->setCompatibleCat(false);
            $animal->setCompatibleDog(false);
            $animal->setCreatedBy($this->getUser());


            $entityManager->persist($animal);
            $entityManager->flush();

            $this->addFlash('success', 'Animal créé avec succès.');
            return $this->redirectToRoute('app_animal_show', ['id' => $animal->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('animal/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_animal_show', methods: ['GET'])]
    public function show(
        Animal $animal
    ): Response {
        return $this->render('animal/show.html.twig', [
            'animal' => $animal,
        ]);
    }

    // Pas de vérification du token car fait avec le formType
    #[Route('/{id}/edit', name: 'app_animal_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_EMPLOYE')]
    public function edit(
        Request $request,
        Animal $animal,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(AnimalType::class, $animal, ['mode' => 'update']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $isVaccinated = $form->get('vaccinated')->getData();
            $isSterilized = $form->get('sterilized')->getData();
            $isChipped = $form->get('chipped')->getData();

            if ($isVaccinated && $isSterilized && $isChipped) {
                $animal->setStatus(AdoptionStatus::A_ADOPTER);
            }

            $animal->setUpdatedBy($this->getUser());

            $entityManager->flush();

            $this->addFlash('success', 'Animal modifié avec succès.');
            return $this->redirectToRoute('app_animal_show', ['id' => $animal->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('animal/edit.html.twig', [
            'animal' => $animal,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_animal_delete', methods: ['POST'])]
    #[IsGranted('ROLE_EMPLOYE')]
    public function delete(
        Request $request,
        Animal $animal,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $animal->getId(), $request->request->get('_token'))) {
            $entityManager->remove($animal);
            $entityManager->flush();
            $this->addFlash('success', 'Utilisateur supprimé avec succès.');
        } else {
            $this->addFlash('error', 'Jeton CSRF invalide.');
        }

        return $this->redirectToRoute('app_animal_page', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/adopt', name: 'app_animal_adopt', methods: ['POST'])]
    #[IsGranted('ROLE_EMPLOYE')]
    public function adopt(
        Request $request,
        Animal $animal,
        EntityManagerInterface $entityManager
    ): Response {

        if (!$this->isCsrfTokenValid('adopt' . $animal->getId(), $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Token CSRF invalide.');
        }

        $animal->setStatus(AdoptionStatus::ADOPTE);
        $animal->setUpdatedBy($this->getUser());

        $entityManager->flush();

        $this->addFlash('success', 'Animal marqué comme adopté.');
        return $this->redirectToRoute('app_animal_page', [], Response::HTTP_SEE_OTHER);
    }
}
