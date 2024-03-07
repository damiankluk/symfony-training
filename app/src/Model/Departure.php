<?php

namespace App\Model;

class Departure
{
    public function __construct(
        public string $time,
        public string $line,
        public string $destination,
        public string $stop
    ) {}
}
