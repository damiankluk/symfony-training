<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Departure;
use App\Model\Departure as DepartureModel;
use App\Repository\DepartureRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final readonly class DepartureService
{
    public function __construct(
        private DepartureRepositoryInterface $departureRepository,
        private EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @return Departure[]
     */
    public function getFilteredDepartures(string $startStopId, string $endStopName): array
    {
        $departuresData = $this->departureRepository->findDeparturesByStartAndEndStop($startStopId, $endStopName);
        $filteredDepartures = [];

        foreach ($departuresData as $departure) {
            if ($departure['destination'] === $endStopName) {
                $filteredDepartures[] = new DepartureModel(
                    time: $departure['time'],
                    line: $departure['line'],
                    destination: $departure['destination'],
                    stop: $departure['stop'],
                );
            }
        }

        return $filteredDepartures;
    }

    public function saveDeparture(array $data): Departure
    {
        try {
            $departure = (new Departure())
                ->setBusStop($data['stop'])
                ->setDestination($data['destination'])
                ->setBusLine($data['line'])
                ->setTime(new \DateTimeImmutable($data['time']));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        $this->entityManager->persist($departure);
        $this->entityManager->flush();

        return $departure;
    }
}
