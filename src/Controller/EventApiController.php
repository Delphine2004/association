<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

final class EventApiController extends AbstractController
{

    #[Route('/event/api', name: 'app_event_index', methods: ['GET'])]
    public function index(
        Request $request,
        EventRepository $eventRepository
    ): JsonResponse {

        // Récupération brute des query params
        $criteria = $request->query->all();

        // Validation légère (si tu veux, tu peux renforcer après)
        if (isset($criteria['id']) && !ctype_digit($criteria['id'])) {
            return $this->json([
                'status' => 'error',
                'message' => 'ID invalide'
            ], 400);
        }

        $events = $eventRepository->findEventsByFields($criteria);

        // Transformation en tableau JSON des propriétés souhaitées
        $data = array_map(function (Event $event) {
            return [
                'id' => $event->getId(),
                'date' => $event->getDate()->format('d/m/Y'),
                'place' => $event->getPlace(),
                'description' => $event->getDescription(),
                'picture' => $event->getPicture() ? '/uploads/events/' . $event->getPicture() : null,

            ];
        }, $events);

        // Réponse JSON cohérente
        return $this->json([
            'status' => 'success',
            'count'  => count($data),
            'events' => $data
        ]);
    }
}
