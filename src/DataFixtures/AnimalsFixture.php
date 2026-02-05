<?php

namespace App\DataFixtures;

use App\Entity\Animal;
use App\Enum\AnimalCategory;
use App\Enum\AnimalRace;
use App\Enum\AnimalGender;
use App\Enum\AdoptionStatus;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AnimalsFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $animalData = [
            [
                'name' => 'Luna',
                'description' => 'Chienne douce et affectueuse, parfaite pour une famille avec enfants',
                'type' => AnimalCategory::CHIEN,
                'race' => AnimalRace::CHIEN_LABRADOR,
                'gender' => AnimalGender::FEMELLE,
                'picture' => 'chien-labrador-1.jpg',
                'status' => AdoptionStatus::A_ADOPTER,
                'vaccinated' => true,
                'sterilized' => true,
                'chipped' => true,
                'compatibleKid' => false,
                'compatibleCat' => false,
                'compatibleDog' => false,
                'arrivalDate' => (new \DateTime())->setTimestamp(mt_rand(
                    strtotime('-1 year'),
                    strtotime('now')
                ))
            ],
            [
                'name' => 'Felix',
                'description' => 'Chat indépendant mais câlin, idéal pour appartement',
                'type' => AnimalCategory::CHAT,
                'race' => AnimalRace::CHAT_SIAMOIS,
                'gender' => AnimalGender::MALE,
                'picture' => 'chat-siamois-1.jpg',
                'status' => AdoptionStatus::A_ADOPTER,
                'vaccinated' => true,
                'sterilized' => true,
                'chipped' => true,
                'compatibleKid' => false,
                'compatibleCat' => false,
                'compatibleDog' => true,
                'arrivalDate' => (new \DateTime())->setTimestamp(mt_rand(
                    strtotime('-1 year'),
                    strtotime('now')
                ))
            ],
            [
                'name' => 'Rocky',
                'description' => 'Chien énergique qui adore les longues promenades et le jeu',
                'type' => AnimalCategory::CHIEN,
                'race' => AnimalRace::CHIEN_HUSKY,
                'gender' => AnimalGender::MALE,
                'picture' => 'chien-husky-1.jpg',
                'status' => AdoptionStatus::A_ADOPTER,
                'vaccinated' => true,
                'sterilized' => true,
                'chipped' => true,
                'compatibleKid' => false,
                'compatibleCat' => false,
                'compatibleDog' => false,
                'arrivalDate' => (new \DateTime())->setTimestamp(mt_rand(
                    strtotime('-1 year'),
                    strtotime('now')
                ))
            ],
            [
                'name' => 'Minou',
                'description' => 'Chatte calme et élégante, recherche un foyer tranquille',
                'type' => AnimalCategory::CHAT,
                'race' => AnimalRace::CHAT_EUROPEEN,
                'gender' => AnimalGender::FEMELLE,
                'picture' => 'chat-1.jpg',
                'status' => AdoptionStatus::A_ADOPTER,
                'vaccinated' => true,
                'sterilized' => true,
                'chipped' => true,
                'compatibleKid' => false,
                'compatibleCat' => false,
                'compatibleDog' => true,
                'arrivalDate' => (new \DateTime())->setTimestamp(mt_rand(
                    strtotime('-1 year'),
                    strtotime('now')
                ))
            ],
            [
                'name' => 'Max',
                'description' => 'Petit chien vif et joueur, excellent compagnon d\'appartement',
                'type' => AnimalCategory::CHIEN,
                'race' => AnimalRace::CHIEN_BEAGLE,
                'gender' => AnimalGender::MALE,
                'picture' => 'chien-beagle1.jpg',
                'status' => AdoptionStatus::A_ADOPTER,
                'vaccinated' => true,
                'sterilized' => true,
                'chipped' => true,
                'compatibleKid' => true,
                'compatibleCat' => true,
                'compatibleDog' => true,
                'arrivalDate' => (new \DateTime())->setTimestamp(mt_rand(
                    strtotime('-1 year'),
                    strtotime('now')
                ))
            ],
            [
                'name' => 'Caramel',
                'description' => 'Chat roux très sociable qui s\'entend bien avec autres animaux',
                'type' => AnimalCategory::CHAT,
                'race' => AnimalRace::CHAT_SIAMOIS,
                'gender' => AnimalGender::MALE,
                'picture' => 'chat-siamois-2.jpg',
                'status' => AdoptionStatus::A_ADOPTER,
                'vaccinated' => true,
                'sterilized' => true,
                'chipped' => true,
                'compatibleKid' => false,
                'compatibleCat' => false,
                'compatibleDog' => true,
                'arrivalDate' => (new \DateTime())->setTimestamp(mt_rand(
                    strtotime('-1 year'),
                    strtotime('now')
                ))
            ],
            [
                'name' => 'Bella',
                'description' => 'Chienne loyale et protectrice, déjà éduquée',
                'type' => AnimalCategory::CHIEN,
                'race' => AnimalRace::CHIEN_CROISE,
                'gender' => AnimalGender::FEMELLE,
                'picture' => 'chien-croise-1.jpg',
                'status' => AdoptionStatus::A_ADOPTER,
                'vaccinated' => true,
                'sterilized' => true,
                'chipped' => true,
                'compatibleKid' => true,
                'compatibleCat' => true,
                'compatibleDog' => true,
                'arrivalDate' => (new \DateTime())->setTimestamp(mt_rand(
                    strtotime('-1 year'),
                    strtotime('now')
                ))
            ],
            [
                'name' => 'Coco',
                'description' => 'Perroquet bavard et coloré, aime l\'interaction humaine',
                'type' => AnimalCategory::OISEAU,
                'race' => AnimalRace::OISEAU_PERROQUET,
                'gender' => AnimalGender::MALE,
                'picture' => 'oiseau_perroquet.jpg',
                'status' => AdoptionStatus::A_ADOPTER,
                'vaccinated' => true,
                'sterilized' => true,
                'chipped' => true,
                'compatibleKid' => false,
                'compatibleCat' => false,
                'compatibleDog' => true,
                'arrivalDate' => (new \DateTime())->setTimestamp(mt_rand(
                    strtotime('-1 year'),
                    strtotime('now')
                ))
            ],
            [
                'name' => 'Simba',
                'description' => 'Chat joueur et curieux, parfait pour première adoption',
                'type' => AnimalCategory::CHAT,
                'race' => AnimalRace::CHAT_EUROPEEN,
                'gender' => AnimalGender::MALE,
                'picture' => 'chat-2.jpg',
                'status' => AdoptionStatus::A_ADOPTER,
                'vaccinated' => true,
                'sterilized' => true,
                'chipped' => true,
                'compatibleKid' => true,
                'compatibleCat' => true,
                'compatibleDog' => true,
                'arrivalDate' => (new \DateTime())->setTimestamp(mt_rand(
                    strtotime('-1 year'),
                    strtotime('now')
                ))
            ],
            [
                'name' => 'Buddy',
                'description' => 'Chien affectueux et patient, idéal avec les enfants',
                'type' => AnimalCategory::CHIEN,
                'race' => AnimalRace::CHIEN_HUSKY,
                'gender' => AnimalGender::MALE,
                'picture' => 'chien-husky-2.jpg',
                'status' => AdoptionStatus::A_ADOPTER,
                'vaccinated' => true,
                'sterilized' => true,
                'chipped' => true,
                'compatibleKid' => true,
                'compatibleCat' => true,
                'compatibleDog' => true,
                'arrivalDate' => (new \DateTime())->setTimestamp(mt_rand(
                    strtotime('-1 year'),
                    strtotime('now')
                ))
            ],
            [
                'name' => 'Noisette',
                'description' => 'Lapine douce et propre, facile à entretenir',
                'type' => AnimalCategory::AUTRE,
                'race' => AnimalRace::AUTRE_LAPIN,
                'gender' => AnimalGender::FEMELLE,
                'picture' => 'lapin-1.jpg',
                'status' => AdoptionStatus::A_ADOPTER,
                'vaccinated' => true,
                'sterilized' => true,
                'chipped' => true,
                'compatibleKid' => true,
                'compatibleCat' => true,
                'compatibleDog' => true,
                'arrivalDate' => (new \DateTime())->setTimestamp(mt_rand(
                    strtotime('-1 year'),
                    strtotime('now')
                ))
            ],
            [
                'name' => 'Oscar',
                'description' => 'Chat senior calme recherchant retraite paisible',
                'type' => AnimalCategory::CHAT,
                'race' => AnimalRace::CHAT_EUROPEEN,
                'gender' => AnimalGender::MALE,
                'picture' => 'chat-3.jpg',
                'status' => AdoptionStatus::A_ADOPTER,
                'vaccinated' => true,
                'sterilized' => true,
                'chipped' => true,
                'compatibleKid' => true,
                'compatibleCat' => true,
                'compatibleDog' => true,
                'arrivalDate' => (new \DateTime())->setTimestamp(mt_rand(
                    strtotime('-1 year'),
                    strtotime('now')
                ))
            ],
            [
                'name' => 'Rex',
                'description' => 'Chien athlétique nécessitant beaucoup d\'exercice',
                'type' => AnimalCategory::CHIEN,
                'race' => AnimalRace::CHIEN_LABRADOR,
                'gender' => AnimalGender::MALE,
                'picture' => 'chien-labrador-2.jpg',
                'status' => AdoptionStatus::A_ADOPTER,
                'vaccinated' => true,
                'sterilized' => true,
                'chipped' => true,
                'compatibleKid' => true,
                'compatibleCat' => true,
                'compatibleDog' => true,
                'arrivalDate' => (new \DateTime())->setTimestamp(mt_rand(
                    strtotime('-1 year'),
                    strtotime('now')
                ))
            ],
            [
                'name' => 'Mango',
                'description' => 'Joyeuse et dynamique, facile à apprivoiser',
                'type' => AnimalCategory::CHIEN,
                'race' => AnimalRace::CHIEN_HUSKY,
                'gender' => AnimalGender::FEMELLE,
                'picture' => 'chien-husky-3.jpg',
                'status' => AdoptionStatus::A_ADOPTER,
                'vaccinated' => true,
                'sterilized' => true,
                'chipped' => true,
                'compatibleKid' => true,
                'compatibleCat' => false,
                'compatibleDog' => false,
                'arrivalDate' => (new \DateTime())->setTimestamp(mt_rand(
                    strtotime('-1 year'),
                    strtotime('now')
                ))
            ],
            [
                'name' => 'Chaussette',
                'description' => 'Chaton espiègle avec des marques blanches aux pattes',
                'type' => AnimalCategory::CHAT,
                'race' => AnimalRace::CHAT_EUROPEEN,
                'gender' => AnimalGender::MALE,
                'picture' => 'chat-chaton-1.jpg',
                'status' => AdoptionStatus::A_ADOPTER,
                'vaccinated' => true,
                'sterilized' => true,
                'chipped' => true,
                'compatibleKid' => true,
                'compatibleCat' => true,
                'compatibleDog' => true,
                'arrivalDate' => (new \DateTime())->setTimestamp(mt_rand(
                    strtotime('-1 year'),
                    strtotime('now')
                ))
            ],
            [
                'name' => 'Toby',
                'description' => 'Petit chien âgé très affectueux cherchant douceur',
                'type' => AnimalCategory::CHIEN,
                'race' => AnimalRace::CHIEN_BEAGLE,
                'gender' => AnimalGender::MALE,
                'picture' => 'chien-beagle2.jpg',
                'status' => AdoptionStatus::A_ADOPTER,
                'vaccinated' => true,
                'sterilized' => true,
                'chipped' => true,
                'compatibleKid' => true,
                'compatibleCat' => false,
                'compatibleDog' => false,
                'arrivalDate' => (new \DateTime())->setTimestamp(mt_rand(
                    strtotime('-1 year'),
                    strtotime('now')
                ))
            ],
            [
                'name' => 'Shadow',
                'description' => 'Chat noir mystérieux et indépendant mais loyal',
                'type' => AnimalCategory::CHAT,
                'race' => AnimalRace::CHAT_EUROPEEN,
                'gender' => AnimalGender::MALE,
                'picture' => 'chat-4.jpg',
                'status' => AdoptionStatus::ADOPTE,
                'vaccinated' => true,
                'sterilized' => true,
                'chipped' => true,
                'compatibleKid' => true,
                'compatibleCat' => true,
                'compatibleDog' => true,
                'arrivalDate' => (new \DateTime())->setTimestamp(mt_rand(
                    strtotime('-1 year'),
                    strtotime('now')
                ))
            ],
            [
                'name' => 'Daisy',
                'description' => 'Chienne gentille et obéissante, bien dressée',
                'type' => AnimalCategory::CHIEN,
                'race' => AnimalRace::CHIEN_LABRADOR,
                'gender' => AnimalGender::FEMELLE,
                'picture' => 'chien-labrador-3.jpg',
                'status' => AdoptionStatus::ADOPTE,
                'vaccinated' => true,
                'sterilized' => true,
                'chipped' => true,
                'compatibleKid' => true,
                'compatibleCat' => false,
                'compatibleDog' => false,
                'arrivalDate' => (new \DateTime())->setTimestamp(mt_rand(
                    strtotime('-1 year'),
                    strtotime('now')
                ))
            ],
            [
                'name' => 'Flocon',
                'description' => 'Sociable et gazouille joyeusement',
                'type' => AnimalCategory::AUTRE,
                'race' => AnimalRace::AUTRE_LAPIN,
                'gender' => AnimalGender::MALE,
                'picture' => 'lapin-2.jpg',
                'status' => AdoptionStatus::EN_SOIN,
                'vaccinated' => true,
                'sterilized' => false,
                'chipped' => true,
                'compatibleKid' => true,
                'compatibleCat' => true,
                'compatibleDog' => true,
                'arrivalDate' => (new \DateTime())->setTimestamp(mt_rand(
                    strtotime('-1 year'),
                    strtotime('now')
                ))
            ],
            [
                'name' => 'Tigrou',
                'description' => 'Chat tigré aventureux qui aime explorer',
                'type' => AnimalCategory::CHAT,
                'race' => AnimalRace::CHAT_EUROPEEN,
                'gender' => AnimalGender::MALE,
                'picture' => 'chat-5.jpg',
                'status' => AdoptionStatus::EN_SOIN,
                'vaccinated' => false,
                'sterilized' => true,
                'chipped' => true,
                'compatibleKid' => true,
                'compatibleCat' => false,
                'compatibleDog' => false,
                'arrivalDate' => (new \DateTime())->setTimestamp(mt_rand(
                    strtotime('-1 year'),
                    strtotime('now')
                ))
            ],
        ];
        foreach ($animalData as $data) {
            $animal = new Animal();
            $animal->setName($data['name']);
            $animal->setDescription($data['description']);
            $animal->setType($data['type']);
            $animal->setRace($data['race']);
            $animal->setGender($data['gender']);
            $animal->setPicture($data['picture']);
            $animal->setStatus($data['status']);
            $animal->setVaccinated($data['vaccinated']);
            $animal->setSterilized($data['sterilized']);
            $animal->setChipped($data['chipped']);
            $animal->setCompatibleKid($data['compatibleKid']);
            $animal->setCompatibleCat($data['compatibleCat']);
            $animal->setCompatibleDog($data['compatibleDog']);
            $animal->setArrivalDate($data['arrivalDate']);


            $manager->persist($animal);
        }
        $manager->flush();
    }
}
