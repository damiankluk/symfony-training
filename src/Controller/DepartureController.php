<?php

namespace App\Controller;

use App\Service\DeparturesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DepartureController extends AbstractController
{
    public function __construct(private readonly DeparturesService $departuresService){}

    #[Route('/departure/{startStopId}/{endStopName}')]
    public function departures(string $startStopId, string $endStopName): Response {
        $result = $this->departuresService->getFilteredDepartures($startStopId, $endStopName);

        return $this->render('departures/list.html.twig', [
            'departures' => $result,
        ]);
    }
}