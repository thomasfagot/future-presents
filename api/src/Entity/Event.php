<?php

namespace App\Entity;

use App\Repository\EventRepository;
use App\Traits\IdEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    use IdEntity;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $cover = null;

    #[ORM\ManyToOne(inversedBy: 'eventCollection')]
    private ?Network $network = null;

    #[ORM\OneToMany(mappedBy: 'event', targetEntity: Wish::class, cascade: ['REMOVE'])]
    private Collection $wishCollection;

    public function __construct()
    {
        $this->wishCollection = new ArrayCollection();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(?string $cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    public function getWishCollection(): Collection
    {
        return $this->wishCollection;
    }

    public function addWishCollection(Wish $wish): self
    {
        if (!$this->wishCollection->contains($wish)) {
            $this->wishCollection[] = $wish;
            $wish->setEvent($this);
        }

        return $this;
    }

    public function removeWishCollection(Wish $wish): self
    {
        if ($this->wishCollection->removeElement($wish) && $wish->getEvent() === $this) {
            $wish->setEvent(null);
        }

        return $this;
    }

    public function getNetwork(): ?Network
    {
        return $this->network;
    }

    public function setNetwork(?Network $network): void
    {
        $this->network = $network;
    }
}
