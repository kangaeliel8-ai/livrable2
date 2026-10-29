<?php

namespace App\Repository;

use App\Entity\Seance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Seance>
 */
class SeanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Seance::class);
    }

    /**
     * Totaux calculés en base (jamais stockés).
     * Sous-requêtes : un double JOIN cotisations + amendes multiplierait les lignes et fausserait les SUM.
     *
     * @return array<int, array<string, mixed>>
     */
    public function findTotauxParCampagne(int $campagneId): array
    {
        return $this->getEntityManager()->createQuery(<<<'DQL'
            SELECT s.id, s.numero, s.dateSeance,
              (SELECT COALESCE(SUM(c1.montantEpargne), 0) FROM App\Entity\Cotisation c1 WHERE c1.seance = s) AS totalCollecte,
              (SELECT COALESCE(SUM(c2.montantCaisse), 0)  FROM App\Entity\Cotisation c2 WHERE c2.seance = s) AS totalCaisse,
              (SELECT COALESCE(SUM(a.montant), 0)         FROM App\Entity\Amende a      WHERE a.seance = s)  AS totalAmendes
            FROM App\Entity\Seance s
            WHERE s.campagne = :campagne
            ORDER BY s.numero ASC
        DQL)
            ->setParameter('campagne', $campagneId)
            ->getArrayResult();
    }

    public function findOneDetail(int $id): ?Seance
    {
        return $this->createQueryBuilder('s')
            ->innerJoin('s.campagne', 'c')->addSelect('c')
            ->leftJoin('s.cotisations', 'co')->addSelect('co')
            ->leftJoin('co.adhesion', 'a')->addSelect('a')
            ->leftJoin('a.membre', 'm')->addSelect('m')
            ->andWhere('s.id = :id')->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
