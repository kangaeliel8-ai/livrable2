<?php

namespace App\Repository;

use App\Entity\Amende;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Amende>
 */
class AmendeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Amende::class);
    }

    /** @return Amende[] */
    public function findBySeance(int $seanceId): array
    {
        return $this->createQueryBuilder('a')
            ->innerJoin('a.adhesion', 'ad')->addSelect('ad')
            ->innerJoin('ad.membre', 'm')->addSelect('m')
            ->andWhere('a.seance = :s')->setParameter('s', $seanceId)
            ->orderBy('m.nom', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
