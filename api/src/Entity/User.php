<?php

namespace App\Entity;

use App\Repository\UserRepository;
use App\Traits\IdEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity('email', message: 'Vous possédez déjà un compte avec cet e-mail.')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use IdEntity;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    #[Assert\Email]
    private ?string $email = null;

    #[ORM\Column(type: 'json')]
    #[Ignore]
    private array $roles = [];

    #[ORM\Column(type: 'string')]
    #[Ignore]
    private ?string $password = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 8)]
    #[Ignore]
    private ?string $plainPassword = null;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    #[Assert\Valid]
    #[Assert\NotBlank]
    private ?Person $person = null;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function eraseCredentials(): self
    {
        $this->plainPassword = null;

        return $this;
    }

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(?Person $person): self
    {
        // unset the owning side of the relation if necessary
        if ($person === null && $this->person !== null) {
            $this->person->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($person !== null && $person->getUser() !== $this) {
            $person->setUser($this);
        }

        $this->person = $person;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }
}
