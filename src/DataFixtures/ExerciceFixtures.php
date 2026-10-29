<?php

namespace App\DataFixtures;

use App\Entity\Exercice;
use App\Entity\Groupement;
use App\Enum\StatutExercice;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class ExerciceFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($g = 0; $g < 3; $g++) {
            $exercice = (new Exercice())
                ->setGroupement($this->getReference("groupement_$g", Groupement::class))
                ->setDateDebut(new \DateTimeImmutable('2026-01-01'))
                ->setDateFin(new \DateTimeImmutable('2026-12-31'))
                ->setDateLimitePret(new \DateTimeImmutable('2026-10-10'))
                ->setDateRetribution(new \DateTimeImmutable('2026-11-01'))
                ->setStatut(StatutExercice::EN_COURS);

            $manager->persist($exercice);
            $this->addReference("exercice_$g", $exercice);
        }

        // Exercice clôturé : prouve que l'« exercice en cours » est bien résolu par le DTO
        $ancien = (new Exercice())
            ->setGroupement($this->getReference('groupement_0', Groupement::class))
            ->setDateDebut(new \DateTimeImmutable('2025-01-01'))
            ->setDateFin(new \DateTimeImmutable('2025-12-31'))
            ->setDateLimitePret(new \DateTimeImmutable('2025-10-10'))
            ->setDateRetribution(new \DateTimeImmutable('2025-11-01'))
            ->setStatut(StatutExercice::CLOTURE);
        $manager->persist($ancien);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [GroupementFixtures::class];
    }
}
