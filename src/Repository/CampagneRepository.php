<?php

namespace App\Repository;

use App\Entity\Campagne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Campagne>
 */
class CampagneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Campagne::class);
    }

    /** @return Campagne[] */
    public function findByGroupement(int $groupementId): array
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.exercice', 'e')->addSelect('e')
            ->innerJoin('e.groupement', 'g')->addSelect('g')
            ->andWhere('g.id = :g')->setParameter('g', $groupementId)
            ->orderBy('e.dateDebut', 'DESC')
            ->addOrderBy('c.nom', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findOneAvecMembres(int $id): ?Campagne
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.exercice', 'e')->addSelect('e')
            ->innerJoin('e.groupement', 'g')->addSelect('g')
            ->leftJoin('c.adhesions', 'a')->addSelect('a')
            ->leftJoin('a.membre', 'm')->addSelect('m')
            ->andWhere('c.id = :id')->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
