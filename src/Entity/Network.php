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

    public function __construct()
    {
        $this->personCollection = new ArrayCollection();
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
}
