<?php

declare(strict_types=1);

namespace App\Repository;

interface DepartureRepositoryInterface
{
    /**
     * @return array<array<string|int, string>>
     */
    public function findDeparturesByStartAndEndStop(string $startStopId, string $endStopName): array;
}
