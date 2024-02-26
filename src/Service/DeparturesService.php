<?php

namespace App\Service;

use App\Model\Departure;
use App\Repository\TransportApiClientRepository;

final readonly class DeparturesService
{
    public function __construct(private TransportApiClientRepository $departureRepository){}

    public function getFilteredDepartures(string $startStopId, string $endStopName): array {
        $departuresData = $this->departureRepository->findDeparturesByStartAndEndStop($startStopId, $endStopName);
        $filteredDepartures = [];

        foreach ($departuresData as $departure) {
            if ($departure['destination'] === $endStopName) {
                $filteredDepartures[] = new Departure (
                    time: $departure['time'],
                    line: $departure['line'],
                    destination: $departure['destination'],
                    stop: $departure['stop'],
                );
            }
        }
        
        return $filteredDepartures;
    }
}