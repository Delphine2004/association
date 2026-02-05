<?php

namespace App\DataFixtures;

use App\Entity\Event;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EventsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $eventData = [
            [
                'date' => new \DateTime('+' . mt_rand(1, 60) . ' days'),
                'place' => '15 rue des Lilas, 99000 QUELQUE PART',
                'description' => 'Journée Portes Ouvertes au Refuge: Un après-midi convivial pour rencontrer nos pensionnaires à quatre pattes dans notre refuge. Venez découvrir chiens, chats et lapins en attente d\'une famille, participer à des ateliers éducatifs sur les soins aux animaux, et échanger avec nos bénévoles autour d\'un goûter solidaire.',
                'picture' => 'event-1.jpg'
            ],
            [
                'date' => new \DateTime('+' . mt_rand(1, 60) . ' days'),
                'place' => 'Place du Marché, 99000 QUELQUE PART',
                'description' => 'Notre stand d\'adoption s\'installe au cœur du centre commercial ! Rencontrez nos animaux disponibles à l\'adoption, repartez avec nos fiches conseils, et soutenez notre association en achetant calendriers, porte-clés et autres goodies dont les bénéfices financent les soins vétérinaires.',
                'picture' => 'event-2.jpg'
            ],
            [
                'date' => new \DateTime('+' . mt_rand(1, 60) . ' days'),
                'place' => 'Parc du lac, 99000 QUELQUE PART',
                'description' => 'Une promenade de 5 km en compagnie de nos chiens du refuge qui ont besoin de socialisation. C\'est l\'occasion idéale de tester l\'affinité avec un futur compagnon tout en profitant d\'un moment nature. Inscription obligatoire, places limitées.',
                'picture' => 'event-3.jpg'
            ],
            [
                'date' => new \DateTime('+' . mt_rand(1, 60) . ' days'),
                'place' => 'Espace Culturel Georges Brassens, 99000 QUELQUE PART',
                'description' => 'Deux jours dédiés au bien-être de nos amis les bêtes : conférences sur la nutrition animale, démonstrations de comportementalistes, corner adoption avec nos protégés, et village de partenaires (vétérinaires, toiletteurs, éducateurs canins).',
                'picture' => 'event-4.jpg'
            ],
            [
                'date' => new \DateTime('+' . mt_rand(1, 60) . ' days'),
                'place' => '15 rue des Lilas, 99000 QUELQUE PART',
                'description' => 'Célébrez avec nous une décennie de dévouement pour nos amis à quatre pattes ! Au programme de cette journée festive : tombola solidaire avec de superbes lots offerts par nos partenaires, espace adoption pour rencontrer nos protégés actuels, stands de restauration dont les bénéfices soutiendront le refuge. Venez nombreux partager !',
                'picture' => 'event-5.jpg'
            ],
            [
                'date' => new \DateTime('+' . mt_rand(1, 60) . ' days'),
                'place' => 'Parking Carrefour, 99000 QUELQUE PART',
                'description' => 'Déposez vos dons de croquettes, litière, couvertures et jouets directement dans nos véhicules sans sortir de votre voiture. Nos bénévoles seront présents pour vous renseigner sur l\'association et vous présenter nos pensionnaires via des tablettes numériques.',
                'picture' => 'event-6.jpg'
            ],
        ];

        foreach ($eventData as $data) {
            $event = new Event();
            $event->setDate($data['date']);
            $event->setPlace($data['place']);
            $event->setDescription($data['description']);
            $event->setPicture($data['picture']);

            $manager->persist($event);
        }
        $manager->flush();
    }
}
