<?php

namespace App\Controller;

use App\Service\SeanceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/seance')]
final class SeanceController extends AbstractController
{
    public function __construct(private readonly SeanceService $service)
    {
    }

    #[Route('/{id<\d+>}', name: 'app_seance_show', methods: ['GET'])]
    public function show(int $id): Response
    {
        $seance = $this->service->detail($id) ?? throw $this->createNotFoundException();

        return $this->render('seance/show.html.twig', ['seance' => $seance]);
    }
}
