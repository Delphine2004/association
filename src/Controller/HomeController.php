<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function renderAdoption(): Response
    {
        return $this->render('home/adoption.html.twig', [
            'message' => 'ajout Bootstrap OK !'
        ]);
    }

    #[Route('/contribution', name: 'contribution')]
    public function renderContribution(): Response
    {
        return $this->render('home/contribution.html.twig', [
            'message' => 'ajout Bootstrap OK !'
        ]);
    }

    #[Route('/event', name: 'event')]
    public function renderEvent(): Response
    {
        return $this->render('home/event.html.twig', [
            'message' => 'ajout Bootstrap OK !'
        ]);
    }
}
