<?php

namespace App\Controller;

use App\Repository\AnimalRepository;
use App\Repository\EventRepository;
use App\Enum\AdoptionStatus;
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
    public function renderHome(
        AnimalRepository $animalRepository,
        EventRepository $eventRepository
    ): Response {

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
        return $this->render('home/donation.html.twig');
    }

    #[Route('/adoption', name: 'adoption')]
    public function renderAdoption(): Response
    {
        return $this->render('home/adoption.html.twig');
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
