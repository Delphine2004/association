<?php

namespace App\Controller;

use App\Repository\AnimalRepository;
use App\Repository\EventRepository;
use App\Entity\Animal;
use App\Enum\AdoptionStatus;
use App\Form\AnimalType;
use App\Service\MongoNewsletterService;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{

    private MongoNewsletterService $newsletterService;

    public function __construct(MongoNewsletterService $newsletterService)
    {
        $this->newsletterService = $newsletterService;
    }

    #[Route('/', name: 'home')]
    public function renderHome(Request $request, MongoNewsletterService $newsletter, AnimalRepository $animalRepository, EventRepository $eventRepository): Response
    {
        if ($request->isMethod('POST')) {
            $email = strtolower(trim($request->request->get('email')));

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->addFlash('error', 'Adresse email invalide.');
                return $this->redirectToRoute('home');
            }

            if ($newsletter->addEmail($email)) {
                $this->addFlash('success', 'Inscription réussie !');
            } else {
                $this->addFlash('warning', 'Cet email est déjà inscrit.');
            }

            return $this->redirectToRoute('home');
        }

        $animalsToAdopt = $animalRepository->findAnimalsByAdoptionStatus(AdoptionStatus::A_ADOPTER);
        $animalsAdopted = $animalRepository->findAnimalsByAdoptionStatus(AdoptionStatus::ADOPTE);
        $events = $eventRepository->findFutureEvents();

        return $this->render('home/index.html.twig', [
            'animalsToAdopt' => $animalsToAdopt,
            'animalsAdopted' => $animalsAdopted,
            'events' => $events,
        ]);
    }

    #[Route('/donation', name: 'donation')]
    public function renderDonation(): Response
    {
        return $this->render('home/donation.html.twig', [
            'message' => 'ajout Bootstrap OK !'
        ]);
    }

    #[Route('/adoption', name: 'adoption')]
    public function renderAdoption(Request $request, AnimalRepository $animalRepository): Response
    {
        // Création du formulaire
        $form = $this->createForm(AnimalType::class);
        $form->handleRequest($request);

        // Données du formulaire
        $criteria = $form->getData();

        // Récupération des animaux filtrés
        $animals = $animalRepository->findAnimalsByFilters($criteria);

        return $this->render('home/adoption.html.twig', [
            'searchForm' => $form->createView(),
            'animals' => $animals,
        ]);
    }

    #[Route('/adoption/{id}', name: 'adoption_animal_show', methods: ['GET'])]
    public function renderAnimal(Animal $animal): Response
    {
        return $this->render('home/adoption_show.html.twig', [
            'animal' => $animal,
        ]);
    }

    #[Route('/conditions', name: 'adoption_terms')]
    public function renderTerms(): Response
    {
        return $this->render('home/adoption_terms.html.twig');
    }

    #[Route('/mentions', name: 'legal_notices')]
    public function renderEvent(): Response
    {
        return $this->render('home/legal_notices.html.twig');
    }
}
