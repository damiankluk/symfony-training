<?php

declare(strict_types=1);

namespace App\Repository;

use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class TransportApiClientRepository implements DepartureRepositoryInterface
{
    public function __construct(private HttpClientInterface $client){}

    /**
     * @inheritdoc
     */
    public function findDeparturesByStartAndEndStop(string $startStopId, string $endStopName): array
    {
        try {
            $response = $this->client->request( 'GET', 'https://poland-public-transport.konhi.workers.dev/v1/zielonagora/mzk/stops/'.$startStopId.'/departures');
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }

        if ($response->getStatusCode() !== 200) {
            throw new \Exception("API CALL failed with status code: ". $response->getStatusCode());
        }

        return $response->toArray();
    }
}