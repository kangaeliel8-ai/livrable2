<?php

namespace App\Controller;

use App\Service\GroupementService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/groupement')]
final class GroupementController extends AbstractController
{
    public function __construct(private readonly GroupementService $service)
    {
    }

    #[Route('', name: 'app_groupement_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('groupement/index.html.twig', [
            'groupements' => $this->service->lister(),
        ]);
    }

    #[Route('/{id<\d+>}', name: 'app_groupement_show', methods: ['GET'])]
    public function show(int $id): Response
    {
        $data = $this->service->detail($id) ?? throw $this->createNotFoundException();

        return $this->render('groupement/show.html.twig', $data);
    }
}
