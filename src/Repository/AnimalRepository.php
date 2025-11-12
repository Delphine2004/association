<?php

namespace App\Repository;

use App\Entity\Animal;

use App\Enum\AnimalType;
use App\Enum\AnimalRace;
use App\Enum\AnimalGender;
use App\Enum\AdoptionStatus;
use App\Enum\SpecificationCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Animal>
 */
class AnimalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Animal::class);
    }


    public function findAnimalById(int $id): ?Animal
    {
        return $this->createQueryBuilder('a')
            ->select('DISTINCT a', 'p', 's') // évite les doublons de ligne
            ->leftJoin('a.pictures', 'p')->addSelect('p') // left inclus l'animal même si pas de photo
            ->leftJoin('a.specifications', 's')->addSelect('s')
            ->andWhere('a.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }



    //---------------------------

    // Par type
    public function findAnimalsByType(AnimalType $type, int $limit = 10, string $orderBy = 'ASC'): array
    {
        return $this->createQueryBuilder('a')
            ->select('DISTINCT a', 'p', 's')
            ->leftJoin('a.pictures', 'p')->addSelect('p')
            ->leftJoin('a.specifications', 's')->addSelect('s')
            ->andWhere('a.type = :type')
            ->setParameter('type', $type->value)
            ->orderBy('a.id',  $orderBy)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    // Par race
    public function findAnimalsByRace(AnimalRace $race, int $limit = 10, string $orderBy = 'ASC'): array
    {
        return $this->createQueryBuilder('a')
            ->select('DISTINCT a', 'p', 's')
            ->leftJoin('a.pictures', 'p')->addSelect('p')
            ->leftJoin('a.specifications', 's')->addSelect('s')
            ->andWhere('a.race = :race')
            ->setParameter('race', $race->value)
            ->orderBy('a.id',  $orderBy)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    // Par genre
    public function findAnimalsByGender(AnimalGender $gender, int $limit = 10, string $orderBy = 'ASC'): array
    {
        return $this->createQueryBuilder('a')
            ->select('DISTINCT a', 'p', 's')
            ->leftJoin('a.pictures', 'p')->addSelect('p')
            ->leftJoin('a.specifications', 's')->addSelect('s')
            ->andWhere('a.gender = :gender')
            ->setParameter('gender', $gender->value)
            ->orderBy('a.id',  $orderBy)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    // Par statut d'adoption
    public function findAnimalsByAdoptionStatus(AdoptionStatus $status, int $limit = 10, string $orderBy = 'ASC'): array
    {
        return $this->createQueryBuilder('a')
            ->select('DISTINCT a', 'p', 's')
            ->leftJoin('a.pictures', 'p')->addSelect('p')
            ->leftJoin('a.specifications', 's')->addSelect('s')
            ->andWhere('a.status = :status')
            ->setParameter('status', $status->value)
            ->orderBy('a.id',  $orderBy)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    // Par vaccination
    public function findAnimalsByVaccination(bool $isVaccinated, int $limit = 10, string $orderBy = 'ASC'): array
    {
        return $this->createQueryBuilder('a')
            ->select('DISTINCT a', 'p', 's')
            ->leftJoin('a.pictures', 'p')->addSelect('p')
            ->leftJoin('a.specifications', 's')->addSelect('s')
            ->andWhere('a.vaccinated = :vaccinated')
            ->setParameter('vaccinated', $isVaccinated)
            ->orderBy('a.id',  $orderBy)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }
    // Par stérilisation
    public function findAnimalsBySterilization(bool $isSterilized, int $limit = 10, string $orderBy = 'ASC'): array
    {
        return $this->createQueryBuilder('a')
            ->select('DISTINCT a', 'p', 's')
            ->leftJoin('a.pictures', 'p')->addSelect('p')
            ->leftJoin('a.specifications', 's')->addSelect('s')
            ->andWhere('a.sterilized = :sterilized')
            ->setParameter('sterilized', $isSterilized)
            ->orderBy('a.id',  $orderBy)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }
    // Par pucage
    public function findAnimalsByChipping(bool $isChipped, int $limit = 10, string $orderBy = 'ASC'): array
    {
        return $this->createQueryBuilder('a')
            ->select('DISTINCT a', 'p', 's')
            ->leftJoin('a.pictures', 'p')->addSelect('p')
            ->leftJoin('a.specifications', 's')->addSelect('s')
            ->andWhere('a.chipped = :chipped')
            ->setParameter('chipped', $isChipped)
            ->orderBy('a.id',  $orderBy)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    // Par catégorie de spécification
    public function findAnimalsBySpecificationCategory(SpecificationCategory $category, int $limit = 10, string $orderBy = 'ASC'): array
    {
        return $this->createQueryBuilder('a')
            ->select('DISTINCT a', 'p', 's')
            ->leftJoin('a.pictures', 'p')->addSelect('p')
            ->leftJoin('a.specifications', 's')->addSelect('s')
            ->andWhere('s.category = :category')
            ->setParameter('category', $category->value)
            ->orderBy('a.id',  $orderBy)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    // Par plusieurs critéres
    public function findAnimalsByFilters(?array $criteria): array
    {
        $qb = $this->createQueryBuilder('a')
            ->select('DISTINCT a', 'p', 's')
            ->leftJoin('a.pictures', 'p')->addSelect('p')
            ->leftJoin('a.specifications', 's')->addSelect('s');

        if (!$criteria) {
            return $qb->getQuery()->getResult();
        }

        if (!empty($criteria['type'])) {
            $qb->andWhere('a.type = :type')
                ->setParameter('type', $criteria['type']->value);
        }

        if (!empty($criteria['race'])) {
            $qb->andWhere('a.race = :race')
                ->setParameter('race', $criteria['race']->value);
        }

        if (!empty($criteria['gender'])) {
            $qb->andWhere('a.gender = :gender')
                ->setParameter('gender', $criteria['gender']->value);
        }

        if (!empty($criteria['compatibleKid'])) {
            $qb->andWhere('a.compatibleKid = true');
        }

        if (!empty($criteria['compatibleCat'])) {
            $qb->andWhere('a.compatibleCat = true');
        }

        if (!empty($criteria['compatibleDog'])) {
            $qb->andWhere('a.compatibleDog = true');
        }

        $qb->orderBy('a.arrivalDate', 'DESC');

        return $qb->getQuery()->getResult();
    }
}
