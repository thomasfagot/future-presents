<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use App\Traits\IdEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PersonRepository::class)]
class Person
{
    use IdEntity;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private ?string $firstname = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max: 255)]
    private ?string $lastname = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max: 255)]
    #[Assert\Url]
    private ?string $avatar = null;

    #[ORM\Column(type: 'date', nullable: true)]
    #[Assert\LessThanOrEqual('today')]
    private ?\DateTimeInterface $dateOfBirth = null;

    #[ORM\OneToOne(inversedBy: 'person', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    #[ORM\ManyToMany(targetEntity: Network::class, mappedBy: 'personCollection')]
    private Collection $networkCollection;

    #[ORM\OneToMany(mappedBy: 'person', targetEntity: Wish::class)]
    private Collection $wishCollection;

    #[ORM\OneToMany(mappedBy: 'person', targetEntity: Reservation::class)]
    private Collection $reservationCollection;

    public function __construct()
    {
        $this->networkCollection = new ArrayCollection();
        $this->wishCollection = new ArrayCollection();
        $this->reservationCollection = new ArrayCollection();
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?\DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getNetworkCollection(): Collection
    {
        return $this->networkCollection;
    }

    public function addNetworkCollection(Network $network): self
    {
        if (!$this->networkCollection->contains($network)) {
            $this->networkCollection[] = $network;
            $network->addPersonCollection($this);
        }

        return $this;
    }

    public function removeNetworkCollection(Network $network): self
    {
        if ($this->networkCollection->removeElement($network)) {
            $network->removePersonCollection($this);
        }

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
            $wish->setPerson($this);
        }

        return $this;
    }

    public function removeWishCollection(Wish $wish): self
    {
        if ($this->wishCollection->removeElement($wish) && $wish->getPerson() === $this) {
            $wish->setPerson(null);
        }

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
            $reservation->setPerson($this);
        }

        return $this;
    }

    public function removeReservationCollection(Reservation $reservation): self
    {
        if ($this->reservationCollection->removeElement($reservation) && $reservation->getPerson() === $this) {
            $reservation->setPerson(null);
        }

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'avatar' => $this->getAvatar(),
            'dateOfBirth' => $this->getDateOfBirth()?->format('c'),
            'firstname' => $this->getFirstname(),
            'lastname' => $this->getLastname(),
        ];
    }
}
