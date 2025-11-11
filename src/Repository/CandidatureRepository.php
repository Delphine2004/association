<?php

namespace App\Repository;

use App\Entity\Candidature;
use App\Enum\CandidatureStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Candidature>
 */
class CandidatureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Candidature::class);
    }

    public function findCandidatureById(int $id): ?Candidature
    {
        return $this->find($id);
    }


    public function findCandidaturesByStatus(CandidatureStatus $status, int $limit = 10, string $orderBy = 'ASC'): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.status = :status')
            ->setParameter('status', $status->value)
            ->orderBy('c.id',  $orderBy)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findCandidaturesByLastName(string $lastName, int $limit = 10, string $orderBy = 'ASC'): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.lastName = :lastName')
            ->setParameter('lastName', $lastName)
            ->orderBy('c.id',  $orderBy)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }
}
