<?php

namespace App\Repository;

use App\Entity\Specification;
use App\Enum\SpecificationCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Specification>
 */
class SpecificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Specification::class);
    }

    public function findSpecificationByCategory(SpecificationCategory $category, int $limit = 10, string $orderBy = 'ASC'): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.category = :category')
            ->setParameter('category', $category)
            ->orderBy('s.id',  $orderBy)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }
}
