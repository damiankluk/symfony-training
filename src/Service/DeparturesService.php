<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Departure;
use App\Repository\DepartureRepositoryInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final readonly class DeparturesService
{
    public function __construct(private DepartureRepositoryInterface $departureRepository)
    {
    }

    /**
     * @return Departure[]
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getFilteredDepartures(string $startStopId, string $endStopName): array
    {
        $departuresData = $this->departureRepository->findDeparturesByStartAndEndStop($startStopId, $endStopName);
        $filteredDepartures = [];

        foreach ($departuresData as $departure) {
            if ($departure['destination'] === $endStopName) {
                $filteredDepartures[] = new Departure(
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
