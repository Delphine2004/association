<?php

namespace App\Controller;

use App\Repository\AnimalRepository;
use App\Form\AnimalSearchType;
use App\Form\NewsletterType;
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
    public function renderHome(Request $request, MongoNewsletterService $newsletter): Response
    {
        if ($request->isMethod('POST')) {
            $email = trim($request->request->get('email'));

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

        return $this->render('home/index.html.twig');
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
