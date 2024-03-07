<?php

namespace App\Tests\Service;

use App\Model\Departure;
use App\Repository\DepartureRepositoryInterface;
use App\Service\DepartureService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class DeparturesServiceTest extends TestCase
{
    private DepartureRepositoryInterface|\Mockery\MockInterface $departureRepository;
    private EntityManagerInterface|\Mockery\MockInterface $entityManager;

    protected function setUp(): void
    {
        $this->departureRepository = \Mockery::mock(DepartureRepositoryInterface::class);
        $this->entityManager = \Mockery::mock(EntityManagerInterface::class);
    }

    public function testGetFilteredDepartures(): void
    {
        $this->departureRepository->shouldReceive('findDeparturesByStartAndEndStop')->andReturn([
            [
                'time' => '3 min',
                'line' => '14',
                'destination' => 'Zawadzkiego Zośki',
                'stop' => '1 Maja',
            ],
            [
                'time' => '5 min',
                'line' => '15',
                'destination' => 'Dead End',
                'stop' => '1 Maja',
            ],
        ]);

        $service = new DepartureService($this->departureRepository, $this->entityManager);

        $result = $service->getFilteredDepartures('75', 'Zawadzkiego Zośki');

        $this->assertEquals([
            new Departure(
                time: '3 min',
                line: '14',
                destination: 'Zawadzkiego Zośki',
                stop: '1 Maja'
            ),
        ], $result);
    }

    public function testGetFilteredDeparturesWithEmptyData(): void
    {
        $this->departureRepository->shouldReceive('findDeparturesByStartAndEndStop')->andReturn([]);

        $service = new DepartureService($this->departureRepository, $this->entityManager);

        $result = $service->getFilteredDepartures('75', 'Zawadzkiego Zośki');

        $this->assertEquals([], $result);
    }

    public function testGetFilteredDeparturesWithAllDataMatchingFilter(): void
    {
        $this->departureRepository->shouldReceive('findDeparturesByStartAndEndStop')->andReturn([
            [
                'time' => '3 min',
                'line' => '14',
                'destination' => 'Zawadzkiego Zośki',
                'stop' => '1 Maja',
            ],
            [
                'time' => '5 min',
                'line' => '15',
                'destination' => 'Zawadzkiego Zośki',
                'stop' => '1 Maja',
            ],
        ]);

        $service = new DepartureService($this->departureRepository, $this->entityManager);

        $result = $service->getFilteredDepartures('75', 'Zawadzkiego Zośki');

        $this->assertEquals([
            new Departure(
                time: '3 min',
                line: '14',
                destination: 'Zawadzkiego Zośki',
                stop: '1 Maja'
            ),
            new Departure(
                time: '5 min',
                line: '15',
                destination: 'Zawadzkiego Zośki',
                stop: '1 Maja'
            ),
        ], $result);
    }

    public function testGetFilteredDeparturesWithSomeDataMatchingFilter(): void
    {
        $this->departureRepository->shouldReceive('findDeparturesByStartAndEndStop')->andReturn([
            [
                'time' => '3 min',
                'line' => '14',
                'destination' => 'Zawadzkiego Zośki',
                'stop' => '1 Maja',
            ],
            [
                'time' => '5 min',
                'line' => '15',
                'destination' => 'Dead End',
                'stop' => '1 Maja',
            ],
        ]);

        $service = new DepartureService($this->departureRepository, $this->entityManager);

        $result = $service->getFilteredDepartures('75', 'Zawadzkiego Zośki');

        $this->assertEquals([
            new Departure(
                time: '3 min',
                line: '14',
                destination: 'Zawadzkiego Zośki',
                stop: '1 Maja'
            ),
        ], $result);
    }

    public function testGetFilteredDeparturesWithNoDataMatchingFilter(): void
    {
        $this->departureRepository->shouldReceive('findDeparturesByStartAndEndStop')->andReturn([
            [
                'time' => '3 min',
                'line' => '14',
                'destination' => 'Dead End',
                'stop' => '1 Maja',
            ],
            [
                'time' => '5 min',
                'line' => '15',
                'destination' => 'Dead End',
                'stop' => '1 Maja',
            ],
        ]);

        $service = new DepartureService($this->departureRepository, $this->entityManager);

        $result = $service->getFilteredDepartures('75', 'Zawadzkiego Zośki');

        $this->assertEquals([], $result);
    }
}
