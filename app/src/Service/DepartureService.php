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
    ) {}

    /**
     * @return array<int<0, max>, DepartureModel>
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

    /**
     * @param array{
     *     stop: string,
     *     destination: string,
     *     line: string,
     *     time: string
     * } $data
     *
     * @throws \Exception
     */
    public function saveDeparture(array $data): Departure
    {
        try {
            $departure = (new Departure())
                ->setBusStop($data['stop'])
                ->setDestination($data['destination'])
                ->setBusLine($data['line'])
                ->setTime($data['time']);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        $this->entityManager->persist($departure);
        $this->entityManager->flush();

        return $departure;
    }

    /**
     * @return Departure[]
     */
    public function getSavedDepartures(): array
    {
        return $this->entityManager->getRepository(Departure::class)->findAll();
    }
}
