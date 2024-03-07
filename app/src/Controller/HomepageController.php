<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\DeparturesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomepageController extends AbstractController
{
    public function __construct(private readonly DeparturesService $departuresService)
    {
    }

    #[Route(path: '/', name: 'homepage')]
    public function homepage(): Response
    {
        $result = $this->departuresService->getFilteredDepartures('75', 'Zawadzkiego Zośki');

        return $this->render('departures/list.html.twig', [
            'departures' => $result,
        ]);
    }
}