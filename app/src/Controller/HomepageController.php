<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\DepartureService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomepageController extends AbstractController
{
    public function __construct(private readonly DepartureService $departuresService) {}

    #[Route(path: '/', name: 'homepage')]
    public function homepage(LoggerInterface $logger): Response
    {
        try {
            $departures = $this->departuresService->getFilteredDepartures('75', 'Zawadzkiego Zośki');
        } catch (\Exception $e) {
            $logger->error('Error occurred while fetching departures from API', ['error' => $e->getMessage()]);
            $departures = [];
        }
        $savedDepartures = $this->departuresService->getSavedDepartures();

        return $this->render('departures/list.html.twig', [
            'departures' => $departures,
            'savedDepartures' => $savedDepartures,
        ]);
    }
}
