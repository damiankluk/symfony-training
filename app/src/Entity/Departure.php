<?php

namespace App\Entity;

use App\Repository\DepartureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepartureRepository::class)]
class Departure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $time;

    #[ORM\Column(length: 255)]
    private string $busLine;

    #[ORM\Column(length: 255)]
    private string $destination;

    #[ORM\Column(length: 255)]
    private string $busStop;

    public function getId(): int
    {
        return $this->id;
    }

    public function getTime(): string
    {
        return $this->time;
    }

    public function setTime(string $time): static
    {
        $this->time = $time;

        return $this;
    }

    public function getBusLine(): string
    {
        return $this->busLine;
    }

    public function setBusLine(string $busLine): static
    {
        $this->busLine = $busLine;

        return $this;
    }

    public function getDestination(): string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): static
    {
        $this->destination = $destination;

        return $this;
    }

    public function getBusStop(): string
    {
        return $this->busStop;
    }

    public function setBusStop(string $busStop): static
    {
        $this->busStop = $busStop;

        return $this;
    }
}
