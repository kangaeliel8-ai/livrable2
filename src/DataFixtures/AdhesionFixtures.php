<?php

namespace App\DataFixtures;

use App\Entity\Adhesion;
use App\Entity\Campagne;
use App\Entity\Membre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class AdhesionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($g = 0; $g < 3; $g++) {
            for ($m = 0; $m < 5; $m++) {
                $libre = ($m === 4); // la dernière membre a choisi le montant libre

                $adhesion = (new Adhesion())
                    ->setMembre($this->getReference("membre_{$g}_{$m}", Membre::class))
                    ->setCampagne($this->getReference("campagne_$g", Campagne::class))
                    ->setIsMontantLibre($libre)
                    ->setMontantEngage($libre ? null : 5000);

                $manager->persist($adhesion);
                $this->addReference("adhesion_{$g}_{$m}", $adhesion);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CampagneFixtures::class, MembreFixtures::class];
    }
}
