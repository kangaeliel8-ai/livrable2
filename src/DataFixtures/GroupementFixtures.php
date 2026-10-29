<?php

namespace App\DataFixtures;

use App\Entity\Groupement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class GroupementFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            ['Les Femmes Battantes', '771110001', 'Médina, Dakar'],
            ['Jigeen Ni',            '772220002', 'Thiaroye'],
            ['Dental Sopey',         '773330003', null],
        ];

        foreach ($data as $i => [$nom, $tel, $adresse]) {
            $groupement = (new Groupement())
                ->setNom($nom)
                ->setTelephone($tel)
                ->setAdresse($adresse);

            $manager->persist($groupement);                       // en mémoire
            $this->addReference("groupement_$i", $groupement);
        }

        $manager->flush();                                        // un seul envoi à la base
    }
}
