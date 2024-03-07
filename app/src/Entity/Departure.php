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
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $time = null;

    #[ORM\Column(length: 255)]
    private ?string $busLine = null;

    #[ORM\Column(length: 255)]
    private ?string $destination = null;

    #[ORM\Column(length: 255)]
    private ?string $busStop = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTime(): ?\DateTimeImmutable
    {
        return $this->time;
    }

    public function setTime(\DateTimeImmutable $time): static
    {
        $this->time = $time;

        return $this;
    }

    public function getBusLine(): ?string
    {
        return $this->busLine;
    }

    public function setBusLine(string $busLine): static
    {
        $this->busLine = $busLine;

        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): static
    {
        $this->destination = $destination;

        return $this;
    }

    public function getBusStop(): ?string
    {
        return $this->busStop;
    }

    public function setBusStop(string $busStop): static
    {
        $this->busStop = $busStop;

        return $this;
    }
}
