<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Enum\AdoptionStatus;
use App\Repository\AnimalRepository;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AnimalApiController extends AbstractController
{

    // Route API qui renvoie le JSON (GET)
    #[Route('/animal/api', name: 'app_animal_index', methods: ['GET'])]
    public function index(
        Request $request,
        AnimalRepository $animalRepository
    ): JsonResponse {

        // Récupération brute des query params
        $criteria = $request->query->all();

        // Convertir les checkbox (1 ou true) en booléens
        $notVaccinated = isset($criteria['notVaccinated']);
        $notSterilized = isset($criteria['notSterilized']);
        $notChipped = isset($criteria['notChipped']);

        // si coché, convertis en = false 
        if ($notVaccinated) {
            $criteria['vaccinated'] = false;
        }
        if ($notSterilized) {
            $criteria['sterilized'] = false;
        }
        if ($notChipped) {
            $criteria['chipped'] = false;
        }

        // Nettoyage des critères (supprime les champs inutiles)
        unset(
            $criteria['notVaccinated'],
            $criteria['notSterilized'],
            $criteria['notChipped'],
            $criteria['compatibleKid'],
            $criteria['compatibleCat'],
            $criteria['compatibleDog']
        );

        // Validation légère (si tu veux, tu peux renforcer après)
        if (isset($criteria['id']) && !ctype_digit($criteria['id'])) {
            return $this->json([
                'status' => 'error',
                'message' => 'ID invalide'
            ], 400);
        }


        // Si l'utilisateur N'EST PAS employé  filtrer automatiquement
        if (!$this->isGranted('ROLE_EMPLOYE')) {
            // Exemple : n'afficher que les animaux "Disponible"
            $criteria['status'] = AdoptionStatus::A_ADOPTER->value;
        }

        // Appel au repo
        $animals = $animalRepository->findAnimalsByFilters($criteria);

        // Transformation en tableau JSON des propriétés souhaitées
        $data = array_map(function (Animal $animal) {
            return [
                'id'            => $animal->getId(),
                'name'          => $animal->getName(),
                'type'           => $animal->getType()->value,
                'race'           => $animal->getRace()->value,
                'gender'        => $animal->getGender()->value,
                'picture'    => $animal->getPicture() ? '/uploads/animals/' . $animal->getPicture() : null,
                'status'       => $animal->getStatus()->value,
            ];
        }, $animals);

        // Réponse JSON cohérente
        return $this->json([
            'status' => 'success',
            'count'  => count($data),
            'animals' => $data
        ]);
    }
}
