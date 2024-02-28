<?php

namespace App\Tests\Repository;

use App\Repository\TransportApiClientRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class TransportApiClientRepositoryTest extends TestCase
{
    public function testFindDeparturesByStartAndEndStop(): void
    {
        $response = \Mockery::mock(ResponseInterface::class);
        $response->shouldReceive('getStatusCode')->andReturn(200);
        $response->shouldReceive('toArray')->andReturn([
            '0' => [
                'time' => '3 min',
                'line' => '14',
                'destination' => 'Zawadzkiego Zośki',
                'stop' => '1 Maja',
            ],
        ]);

        $client = \Mockery::mock(HttpClientInterface::class);
        $client->shouldReceive('request')->andReturn($response);

        $repository = new TransportApiClientRepository($client);

        $result = $repository->findDeparturesByStartAndEndStop('75', 'Zawadzkiego Zośki');

        $this->assertEquals([
            '0' => [
                'time' => '3 min',
                'line' => '14',
                'destination' => 'Zawadzkiego Zośki',
                'stop' => '1 Maja',
            ],
        ], $result);
    }

    public function testFindDeparturesByStartAndEndStopWithHttpError(): void
    {
        $response = \Mockery::mock(ResponseInterface::class);
        $response->shouldReceive('getStatusCode')->andReturn(500);

        $client = \Mockery::mock(HttpClientInterface::class);
        $client->shouldReceive('request')->andReturn($response);

        $repository = new TransportApiClientRepository($client);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('API CALL failed with status code: 500');

        $repository->findDeparturesByStartAndEndStop('75', 'Zawadzkiego Zośki');
    }

    public function testFindDeparturesByStartAndEndStopWithException(): void
    {
        $client = \Mockery::mock(HttpClientInterface::class);
        $client->shouldReceive('request')->andThrow(\Exception::class, 'API request failed');

        $repository = new TransportApiClientRepository($client);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('API request failed');

        $repository->findDeparturesByStartAndEndStop('75', 'Zawadzkiego Zośki');
    }

    public function testFindDeparturesByStartAndEndStopWithEmptyResponse(): void
    {
        $response = \Mockery::mock(ResponseInterface::class);
        $response->shouldReceive('getStatusCode')->andReturn(200);
        $response->shouldReceive('toArray')->andReturn([]);

        $client = \Mockery::mock(HttpClientInterface::class);
        $client->shouldReceive('request')->andReturn($response);

        $repository = new TransportApiClientRepository($client);

        $result = $repository->findDeparturesByStartAndEndStop('75', 'Zawadzkiego Zośki');

        $this->assertEquals([], $result);
    }

    public function testFindDeparturesByStartAndEndStopWithUnexpectedDataFormat(): void
    {
        $response = \Mockery::mock(ResponseInterface::class);
        $response->shouldReceive('getStatusCode')->andReturn(200);
        $response->shouldReceive('toArray')->andReturn([
            'unexpected_key' => 'unexpected_value',
        ]);

        $client = \Mockery::mock(HttpClientInterface::class);
        $client->shouldReceive('request')->andReturn($response);

        $repository = new TransportApiClientRepository($client);

        $result = $repository->findDeparturesByStartAndEndStop('75', 'Zawadzkiego Zośki');

        $this->assertEquals([
            'unexpected_key' => 'unexpected_value',
        ], $result);
    }
}
