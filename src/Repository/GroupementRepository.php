<?php

namespace App\Repository;

use App\Entity\Groupement;
use App\Enum\StatutExercice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Groupement>
 */
class GroupementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Groupement::class);
    }

    /**
     * @return Groupement[]
     * Une seule requête : le LEFT JOIN conditionnel ramène l'exercice en cours (pas de N+1).
     */
    public function findAllAvecExerciceEnCours(): array
    {
        return $this->createQueryBuilder('g')
            ->leftJoin('g.exercices', 'e', 'WITH', 'e.statut = :statut')
            ->addSelect('e')
            ->setParameter('statut', StatutExercice::EN_COURS)
            ->orderBy('g.nom', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
