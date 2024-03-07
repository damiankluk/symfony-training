<?php

declare(strict_types=1);

namespace App\Repository;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class TransportApiClientRepository implements DepartureRepositoryInterface
{
    public function __construct(private HttpClientInterface $client) {}

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws \Exception
     */
    public function findDeparturesByStartAndEndStop(string $startStopId, string $endStopName): array
    {
        try {
            $response = $this->client->request('GET', 'https://poland-public-transport.konhi.workers.dev/v1/zielonagora/mzk/stops/' . $startStopId . '/departures');
        } catch (\Exception $exception) {
            throw new \RuntimeException($exception->getMessage());
        }

        if (Response::HTTP_OK !== $response->getStatusCode()) {
            throw new \RuntimeException('API CALL failed with status code: ' . $response->getStatusCode());
        }

        return $response->toArray();
    }
}
