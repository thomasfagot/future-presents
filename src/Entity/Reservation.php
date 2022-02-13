<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use App\Traits\IdEntity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    use IdEntity;

    #[ORM\ManyToOne(inversedBy: 'reservationCollection')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Wish $wish = null;

    #[ORM\ManyToOne(inversedBy: 'reservationCollection')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Person $person = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $status = null;

    public function getWish(): ?Wish
    {
        return $this->wish;
    }

    public function setWish(?Wish $wish): self
    {
        $this->wish = $wish;

        return $this;
    }

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(?Person $person): self
    {
        $this->person = $person;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
}
