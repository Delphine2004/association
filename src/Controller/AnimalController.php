<?php

namespace App\Controller;

use App\Repository\AnimalRepository;
use App\Entity\Animal;
use App\Enum\AdoptionStatus;
use App\Form\AnimalType;
use App\Form\AnimalSearchStaffType;
use App\Form\AnimalUpdateType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/animal')]
final class AnimalController extends AbstractController
{

    public function __construct(private string $uploadsAnimalsDirectory) {}

    #[Route(name: 'app_animal_index', methods: ['GET'])]
    public function index(
        Request $request,
        AnimalRepository $animalRepository
    ): Response {

        // Création du formulaire
        $form = $this->createForm(AnimalSearchStaffType::class);
        $form->handleRequest($request);

        // Données du formulaire
        $criteria = $form->getData();
        $notSterilized = $form->get('notSterilized')->getData();
        $criteria['sterilized'] = $notSterilized ? false : null;
        $notVaccinated = $form->get('notVaccinated')->getData();
        $criteria['vaccinated'] = $notVaccinated ? false : null;

        $animals = $animalRepository->findAnimalsByFilters($criteria);

        // Recrée un formulaire vide, sans données préremplies
        $form = $this->createForm(AnimalSearchStaffType::class);

        return $this->render('animal/index.html.twig', [
            'searchForm' => $form->createView(),
            'animals' => $animals,
        ]);
    }

    #[Route('/new', name: 'app_animal_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $animal = new Animal();
        $form = $this->createForm(AnimalType::class, $animal);
        $form->handleRequest($request);

        //dump($form->isSubmitted());
        //dump($form->isValid());
        //dump($form->getErrors(true));

        if ($form->isSubmitted() && $form->isValid()) {
            //  Récupérer le fichier uploadé (UploadedFile ou null)
            $uploadedFile = $form->get('picture')->getData();

            if ($uploadedFile) {

                //  Générer un nom unique (ex: 654a51b8d1e21.jpg)
                $fileName = uniqid() . '.' . $uploadedFile->guessExtension();

                //  Déplacer le fichier dans ton dossier uploads
                $uploadedFile->move($this->uploadsAnimalsDirectory, $fileName);

                //  Stocker le nom du fichier dans l'entité
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
    public function show(Animal $animal): Response
    {
        return $this->render('animal/show.html.twig', [
            'animal' => $animal,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_animal_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Animal $animal,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(AnimalUpdateType::class, $animal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // récupérations des caractéristiques santé
            $isVaccinated = $form->get('vaccinated')->getData();
            $isSterilized = $form->get('sterilized')->getData();
            $isChipped = $form->get('chipped')->getData();

            if ($isVaccinated && $isSterilized && $isChipped) {
                $animal->setStatus(AdoptionStatus::A_ADOPTER);
            }

            $animal->setUpdatedBy($this->getUser());

            $entityManager->flush();

            return $this->redirectToRoute('app_animal_show', ['id' => $animal->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('animal/edit.html.twig', [
            'animal' => $animal,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/adopt', name: 'app_animal_adopt', methods: ['POST'])]
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
        return $this->redirectToRoute('app_animal_index', [], Response::HTTP_SEE_OTHER);
    }



    #[Route('/{id}', name: 'app_animal_delete', methods: ['POST'])]
    public function delete(Request $request, Animal $animal, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $animal->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($animal);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_animal_index', [], Response::HTTP_SEE_OTHER);
    }
}
