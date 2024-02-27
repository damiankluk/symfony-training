<?php

namespace App\Tests\Service;

use App\Repository\DepartureRepositoryInterface;
use App\Service\DeparturesService;
use App\Model\Departure;
use PHPUnit\Framework\TestCase;
use Mockery;

class DeparturesServiceTest extends TestCase
{
    public function testGetFilteredDepartures()
    {
        $departureRepository = Mockery::mock(DepartureRepositoryInterface::class);
        $departureRepository->shouldReceive('findDeparturesByStartAndEndStop')->andReturn([
            [
                'time' => '3 min',
                'line' => '14',
                'destination' => 'Zawadzkiego Zośki',
                'stop' => '1 Maja'
            ],
            [
                'time' => '5 min',
                'line' => '15',
                'destination' => 'Dead End',
                'stop' => '1 Maja'
            ]
        ]);

        $service = new DeparturesService($departureRepository);

        $result = $service->getFilteredDepartures('75', 'Zawadzkiego Zośki');

        $this->assertEquals([
            new Departure(
                time: '3 min',
                line: '14',
                destination: 'Zawadzkiego Zośki',
                stop: '1 Maja'
            )
        ], $result);
    }

    public function testGetFilteredDeparturesWithEmptyData()
    {
        $departureRepository = Mockery::mock(DepartureRepositoryInterface::class);
        $departureRepository->shouldReceive('findDeparturesByStartAndEndStop')->andReturn([]);

        $service = new DeparturesService($departureRepository);

        $result = $service->getFilteredDepartures('75', 'Zawadzkiego Zośki');

        $this->assertEquals([], $result);
    }

    public function testGetFilteredDeparturesWithAllDataMatchingFilter()
    {
        $departureRepository = Mockery::mock(DepartureRepositoryInterface::class);
        $departureRepository->shouldReceive('findDeparturesByStartAndEndStop')->andReturn([
            [
                'time' => '3 min',
                'line' => '14',
                'destination' => 'Zawadzkiego Zośki',
                'stop' => '1 Maja'
            ],
            [
                'time' => '5 min',
                'line' => '15',
                'destination' => 'Zawadzkiego Zośki',
                'stop' => '1 Maja'
            ]
        ]);

        $service = new DeparturesService($departureRepository);

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
            )
        ], $result);
    }

    public function testGetFilteredDeparturesWithSomeDataMatchingFilter()
    {
        $departureRepository = Mockery::mock(DepartureRepositoryInterface::class);
        $departureRepository->shouldReceive('findDeparturesByStartAndEndStop')->andReturn([
            [
                'time' => '3 min',
                'line' => '14',
                'destination' => 'Zawadzkiego Zośki',
                'stop' => '1 Maja'
            ],
            [
                'time' => '5 min',
                'line' => '15',
                'destination' => 'Dead End',
                'stop' => '1 Maja'
            ]
        ]);

        $service = new DeparturesService($departureRepository);

        $result = $service->getFilteredDepartures('75', 'Zawadzkiego Zośki');

        $this->assertEquals([
            new Departure(
                time: '3 min',
                line: '14',
                destination: 'Zawadzkiego Zośki',
                stop: '1 Maja'
            )
        ], $result);
    }

    public function testGetFilteredDeparturesWithNoDataMatchingFilter()
    {
        $departureRepository = Mockery::mock(DepartureRepositoryInterface::class);
        $departureRepository->shouldReceive('findDeparturesByStartAndEndStop')->andReturn([
            [
                'time' => '3 min',
                'line' => '14',
                'destination' => 'Dead End',
                'stop' => '1 Maja'
            ],
            [
                'time' => '5 min',
                'line' => '15',
                'destination' => 'Dead End',
                'stop' => '1 Maja'
            ]
        ]);

        $service = new DeparturesService($departureRepository);

        $result = $service->getFilteredDepartures('75', 'Zawadzkiego Zośki');

        $this->assertEquals([], $result);
    }
}
