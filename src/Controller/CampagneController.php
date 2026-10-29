<?php

namespace App\Controller;

use App\Service\CampagneService;
use App\Service\SeanceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/campagne')]
final class CampagneController extends AbstractController
{
    public function __construct(
        private readonly CampagneService $campagneService,
        private readonly SeanceService $seanceService,
    ) {
    }

    #[Route('/{id<\d+>}', name: 'app_campagne_show', methods: ['GET'])]
    public function show(int $id): Response
    {
        $data = $this->campagneService->detail($id) ?? throw $this->createNotFoundException();

        return $this->render('campagne/show.html.twig', $data);
    }

    #[Route('/{id<\d+>}/seances', name: 'app_campagne_seances', methods: ['GET'])]
    public function seances(int $id): Response
    {
        $data = $this->campagneService->detail($id) ?? throw $this->createNotFoundException();

        return $this->render('campagne/seances.html.twig', [
            'campagne' => $data['campagne'],
            'seances' => $this->seanceService->totauxParCampagne($id),
        ]);
    }
}
