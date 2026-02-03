<?php

namespace App\Controller;

use App\Service\MongoNewsletterService;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

final class HomeApiController extends AbstractController
{

    #[Route('/home/api', name: 'app_new_letter', methods: ['POST'])]
    public function addEmail(
        Request $request,
        MongoNewsletterService $newsletter
    ): JsonResponse {

        $data = json_decode($request->getContent(), true);

        if (!$data || !isset($data['email'])) {
            return $this->json([
                'success' => false,
                'message' => 'Données invalides',
            ], 400);
        }

        $email = strtolower(trim($data['email']));
        $agreement = !empty($data['agreement']);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->json([
                'success' => false,
                'message' => 'Email invalide',
            ], 422);
        }

        if (!$agreement) {
            return $this->json([
                'success' => false,
                'message' => 'Consentement requis',
            ], 422);
        }

        if (!$newsletter->addEmail($email, $agreement)) {
            return $this->json([
                'success' => false,
                'message' => 'Email déjà inscrit',
            ], 409);
        }

        return $this->json([
            'success' => true,
            'message' => 'Inscription réussie',
        ]);
    }
}
