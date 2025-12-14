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

    // Par statut d'adoption
    public function findAnimalsByAdoptionStatus(
        AdoptionStatus $status,
        int $limit = 10,
        string $orderBy = 'DESC'
    ): array {
        return $this->createQueryBuilder('a')
            ->andWhere('a.status = :status')
            ->setParameter('status', $status->value)
            ->orderBy('a.updatedAt',  $orderBy)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }


    // Par plusieurs critéres
    public function findAnimalsByFilters(
        ?array $criteria,
        int $limit = 10,
        string $orderBy = 'DESC'
    ): array {

        $qb = $this->createQueryBuilder('a');

        if (!empty($criteria['id'])) {
            $qb->andWhere('a.id = :id')
                ->setParameter('id', $criteria['id']);
        }

        if (!empty($criteria['name'])) {
            $qb->andWhere('a.name LIKE :name')
                ->setParameter('name', '%' . $criteria['name'] . '%');
        }

        $enumFields = ['type', 'race', 'gender', 'status'];
        foreach ($enumFields as $field) {
            if (!empty($criteria[$field])) {
                $qb->andWhere("a.$field = :$field")
                    ->setParameter($field, $criteria[$field]);
            }
        }

        $boolFields = ['compatibleKid', 'compatibleCat', 'compatibleDog', 'sterilized', 'vaccinated', 'chipped'];
        foreach ($boolFields as $field) {
            if (isset($criteria[$field])) {
                $qb->andWhere("a.$field = :$field")
                    ->setParameter($field, $criteria[$field]);
            }
        }

        if (!empty($criteria['arrivalDate'])) {
            $qb->andWhere('a.arrivalDate = :arrivalDate')
                ->setParameter('arrivalDate', $criteria['arrivalDate']->format('Y-m-d'));
        }

        return $qb->orderBy('a.updatedAt',  $orderBy)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
