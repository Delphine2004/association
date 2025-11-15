<?php

namespace App\Repository;

use App\Entity\Animal;

use App\Enum\AdoptionStatus;
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
            ->andWhere('a.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }



    //---------------------------



    // Par statut d'adoption
    public function findAnimalsByAdoptionStatus(AdoptionStatus $status, int $limit = 10, string $orderBy = 'ASC'): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.status = :status')
            ->setParameter('status', $status->value)
            ->orderBy('a.id',  $orderBy)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }


    // Par plusieurs critéres
    public function findAnimalsByFilters(?array $criteria): array
    {
        $qb = $this->createQueryBuilder('a');

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
