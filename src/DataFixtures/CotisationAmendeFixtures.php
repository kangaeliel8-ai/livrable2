<?php

namespace App\DataFixtures;

use App\Entity\Adhesion;
use App\Entity\Amende;
use App\Entity\Campagne;
use App\Entity\Cotisation;
use App\Entity\Seance;
use App\Enum\StatutPresence;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Illustre les 3 scénarios métier :
 *  - présent            : épargne + caisse_present
 *  - absent représenté  : épargne + caisse_absent
 *  - absent non payé    : amende journalière cumulée (ex. dimanche -> mercredi = 3 x 350 = 1 050 FCFA)
 */
final class CotisationAmendeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($g = 0; $g < 3; $g++) {
            for ($s = 0; $s < 3; $s++) {
                $seance = $this->getReference("seance_{$g}_{$s}", Seance::class);

                for ($m = 0; $m < 5; $m++) {
                    $adhesion = $this->getReference("adhesion_{$g}_{$m}", Adhesion::class);
                    $campagne = $adhesion->getCampagne();

                    $presence = match (true) {
                        $m === 2             => StatutPresence::ABSENT_REPRESENTE,
                        $m === 3 && $s === 1 => StatutPresence::ABSENT_NON_PAYE,
                        default              => StatutPresence::PRESENT,
                    };

                    [$epargne, $caisse] = match ($presence) {
                        StatutPresence::PRESENT           => [$this->epargne($adhesion, $campagne, $s), $campagne->getMontantCaissePresent()],
                        StatutPresence::ABSENT_REPRESENTE => [$this->epargne($adhesion, $campagne, $s), $campagne->getMontantCaisseAbsent()],
                        StatutPresence::ABSENT_NON_PAYE   => [0, 0],
                    };

                    $manager->persist(
                        (new Cotisation())
                            ->setAdhesion($adhesion)
                            ->setSeance($seance)
                            ->setPresence($presence)
                            ->setMontantEpargne($epargne)
                            ->setMontantCaisse($caisse)
                    );

                    if ($presence === StatutPresence::ABSENT_NON_PAYE) {
                        $jours = 3;
                        $manager->persist(
                            (new Amende())
                                ->setAdhesion($adhesion)
                                ->setSeance($seance)
                                ->setNombreJours($jours)
                                ->setMontant($jours * $campagne->getMontantAmendeJournaliere())
                                ->setIsPayee(false)
                        );
                    }
                }
            }
        }

        $manager->flush();
    }

    private function epargne(Adhesion $a, Campagne $c, int $s): int
    {
        return $a->isMontantLibre() ? 2000 + $s * 500 : $c->getMontantFixe();
    }

    public function getDependencies(): array
    {
        return [AdhesionFixtures::class, SeanceFixtures::class];
    }
}
