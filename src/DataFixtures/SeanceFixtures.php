<?php

namespace App\DataFixtures;

use App\Entity\Campagne;
use App\Entity\Seance;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class SeanceFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $dates = ['2026-01-04', '2026-01-11', '2026-01-18']; // trois dimanches

        for ($g = 0; $g < 3; $g++) {
            foreach ($dates as $s => $date) {
                $seance = (new Seance())
                    ->setCampagne($this->getReference("campagne_$g", Campagne::class))
                    ->setNumero($s + 1)
                    ->setDateSeance(new \DateTimeImmutable($date));

                $manager->persist($seance);
                $this->addReference("seance_{$g}_{$s}", $seance);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CampagneFixtures::class];
    }
}
