<?php

namespace App\Repository;

use App\Entity\Event;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Event>
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function findEventById(int $id): ?Event
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findFutureEvents(int $limit = 10, string $orderBy = 'ASC'): array
    {
        $now = new DateTimeImmutable('today');

        return $this->createQueryBuilder('e')
            ->where('e.date >= :now')
            ->setParameter('now', $now)
            ->orderBy('e.id',  $orderBy)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findEventsByFields(?array $criteria, int $limit = 10, string $orderBy = 'ASC'): array
    {
        $qb = $this->createQueryBuilder('e');

        if (!empty($criteria['id'])) {
            $qb->andWhere('e.id = :id')
                ->setParameter('id', $criteria['id']);
        }

        if (!empty($criteria['date'])) {
            $date = $criteria['date'];
            if ($date instanceof \DateTimeInterface) {
                $qb->andWhere('e.date = :date')
                    ->setParameter('date', $date->format('Y-m-d'));
            }
        }

        return $qb->orderBy('e.id',  $orderBy)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
