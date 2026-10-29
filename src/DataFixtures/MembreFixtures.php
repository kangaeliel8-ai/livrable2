<?php

namespace App\DataFixtures;

use App\Entity\Groupement;
use App\Entity\Membre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class MembreFixtures extends Fixture implements DependentFixtureInterface
{
    private const NOMS = [
        ['Diop', 'Awa'], ['Fall', 'Fatou'], ['Ndiaye', 'Aminata'], ['Sow', 'Khady'], ['Ba', 'Mariama'],
    ];

    public function load(ObjectManager $manager): void
    {
        for ($g = 0; $g < 3; $g++) {
            foreach (self::NOMS as $m => [$nom, $prenom]) {
                $membre = (new Membre())
                    ->setGroupement($this->getReference("groupement_$g", Groupement::class))
                    ->setNom($nom)
                    ->setPrenom($prenom)
                    ->setTelephone('77' . $g . '00000' . $m);

                $manager->persist($membre);
                $this->addReference("membre_{$g}_{$m}", $membre);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [GroupementFixtures::class];
    }
}
