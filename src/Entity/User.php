<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields:"email", message:"Ya existe una cuenta con este email")]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150, unique:true)]
    private ?string $email = null;

    #[ORM\Column(length: 150)]
    private ?string $password = null;

    #[ORM\Column]
    private array $roles = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles():array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles):self
    {
        $this -> roles = $roles;
        return $this;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials()
    {}

    public function getUserIdentifier(): string
    {
        return (string) $this -> email;
    }

    public function getUsername(): string
    {
        return (string) $this -> email;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword():string
    {
        return $this -> password;
    }

    public function setPassword(string $password):self
    {
        $this -> password = $password;
        return $this;
    }
}
