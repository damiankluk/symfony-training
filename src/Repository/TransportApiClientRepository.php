<?php

declare(strict_types=1);

namespace App\Repository;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class TransportApiClientRepository implements DepartureRepositoryInterface
{
    public function __construct(private HttpClientInterface $client)
    {
    }

    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Exception
     */
    public function findDeparturesByStartAndEndStop(string $startStopId, string $endStopName): array
    {
        try {
            $response = $this->client->request('GET', 'https://poland-public-transport.konhi.workers.dev/v1/zielonagora/mzk/stops/'.$startStopId.'/departures');
        } catch (\Exception $exception) {
            throw new \RuntimeException($exception->getMessage());
        }

        if (Response::HTTP_OK !== $response->getStatusCode()) {
            throw new \RuntimeException('API CALL failed with status code: '.$response->getStatusCode());
        }

        return $response->toArray();
    }
}
