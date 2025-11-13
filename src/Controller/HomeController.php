<?php

namespace App\Controller;

use App\Repository\AnimalRepository;
use App\Form\AnimalSearchType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function renderHome(): Response
    {
        return $this->render('home/index.html.twig', [
            'message' => 'ajout Bootstrap OK !'
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
        $form = $this->createForm(AnimalSearchType::class);
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

    #[Route('/evenements', name: 'events')]
    public function renderEvent(): Response
    {
        return $this->render('home/event.html.twig', [
            'message' => 'ajout Bootstrap OK !'
        ]);
    }
}
