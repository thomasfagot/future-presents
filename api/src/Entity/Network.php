<?php

namespace App\Entity;

use App\Repository\NetworkRepository;
use App\Traits\IdEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NetworkRepository::class)]
class Network
{
    use IdEntity;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Person::class, inversedBy: 'networkCollection')]
    private Collection $personCollection;

    #[ORM\OneToMany(mappedBy: 'network', targetEntity: Event::class)]
    private Collection $eventCollection;

    public function __construct()
    {
        $this->personCollection = new ArrayCollection();
        $this->eventCollection = new ArrayCollection();
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

    public function getPersonCollection(): Collection
    {
        return $this->personCollection;
    }

    public function addPersonCollection(Person $person): self
    {
        if (!$this->personCollection->contains($person)) {
            $this->personCollection[] = $person;
        }

        return $this;
    }

    public function removePersonCollection(Person $person): self
    {
        $this->personCollection->removeElement($person);

        return $this;
    }

    public function getEventCollection(): Collection
    {
        return $this->eventCollection;
    }

    public function addEventCollection(Event $event): self
    {
        if (!$this->eventCollection->contains($event)) {
            $this->eventCollection[] = $event;
        }

        return $this;
    }

    public function removeEventCollection(Event $event): self
    {
        $this->eventCollection->removeElement($event);

        return $this;
    }
}
