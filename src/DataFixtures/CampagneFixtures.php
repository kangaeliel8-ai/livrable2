<?php

namespace App\DataFixtures;

use App\Entity\Campagne;
use App\Entity\Exercice;
use App\Enum\Periodicite;
use App\Enum\TypeCampagne;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class CampagneFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($g = 0; $g < 3; $g++) {
            $campagne = (new Campagne())
                ->setExercice($this->getReference("exercice_$g", Exercice::class))
                ->setNom('Épargne Calebasse')
                ->setType(TypeCampagne::EPARGNE_CALEBASSE)
                ->setPeriodicite(Periodicite::HEBDOMADAIRE)
                ->setJourRencontre('dimanche')
                ->setMontantFixe(5000)
                ->setMontantCaissePresent(100)
                ->setMontantCaisseAbsent(300)
                ->setMontantAmendeJournaliere(350);

            $manager->persist($campagne);
            $this->addReference("campagne_$g", $campagne);
        }

        $tontine = (new Campagne())
            ->setExercice($this->getReference('exercice_0', Exercice::class))
            ->setNom('Tontine mensuelle')
            ->setType(TypeCampagne::TONTINE)
            ->setPeriodicite(Periodicite::MENSUEL)
            ->setJourRencontre('1er samedi')
            ->setMontantFixe(10000)
            ->setMontantCaissePresent(0)
            ->setMontantCaisseAbsent(0)
            ->setMontantAmendeJournaliere(0);
        $manager->persist($tontine);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [ExerciceFixtures::class];
    }
}
