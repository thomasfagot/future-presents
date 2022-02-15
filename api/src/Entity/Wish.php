<?php

namespace App\Entity;

use App\Repository\WishRepository;
use App\Traits\IdEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WishRepository::class)]
class Wish
{
    use IdEntity;

    #[ORM\ManyToOne(inversedBy: 'wishCollection')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Item $item = null;

    #[ORM\ManyToOne(inversedBy: 'wishCollection')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Person $person = null;

    #[ORM\ManyToOne(inversedBy: 'wishCollection')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Event $event = null;

    #[ORM\OneToMany(mappedBy: 'wish', targetEntity: Reservation::class, cascade: ['REMOVE'])]
    private Collection $reservationCollection;

    public function __construct()
    {
        $this->reservationCollection = new ArrayCollection();
    }

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function setItem(?Item $item): self
    {
        $this->item = $item;

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

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function getReservationCollection(): Collection
    {
        return $this->reservationCollection;
    }

    public function addReservationCollection(Reservation $reservation): self
    {
        if (!$this->reservationCollection->contains($reservation)) {
            $this->reservationCollection[] = $reservation;
            $reservation->setWish($this);
        }

        return $this;
    }

    public function removeReservationCollection(Reservation $reservation): self
    {
        if ($this->reservationCollection->removeElement($reservation) && $reservation->getWish() === $this) {
            $reservation->setWish(null);
        }

        return $this;
    }
}
