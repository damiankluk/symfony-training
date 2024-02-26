<?php

namespace App\Repository;

interface DepartureRepositoryInterface
{
    public function findDeparturesByStartAndEndStop(string $startStopId, string $endStopName): array;
}