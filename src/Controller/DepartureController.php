<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\DeparturesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DepartureController extends AbstractController
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

    #[Route(path: '/departure/{startStopId}/{endStopName}', name: 'departures')]
    public function departures(string $startStopId, string $endStopName): Response
    {
        $result = $this->departuresService->getFilteredDepartures($startStopId, $endStopName);

        return $this->render('departures/list.html.twig', [
            'departures' => $result,
        ]);
    }
}
