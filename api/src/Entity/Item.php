<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use App\Traits\IdEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
class Item
{
    use IdEntity;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: 'text', length: 65535, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'string', length: 1023, nullable: true)]
    private ?string $url = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $price = null;

    #[ORM\OneToMany(mappedBy: 'item', targetEntity: Wish::class)]
    private Collection $wishCollection;

    public function __construct()
    {
        $this->wishCollection = new ArrayCollection();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): self
    {
        $this->price = $price;

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
            $wish->setItem($this);
        }

        return $this;
    }

    public function removeWishCollection(Wish $wish): self
    {
        if ($this->wishCollection->removeElement($wish) && $wish->getItem() === $this) {
            $wish->setItem(null);
        }

        return $this;
    }
}
