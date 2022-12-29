<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity('email', 'Cet e-mail existe déjà au sein de l\'application')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue('CUSTOM')]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\CustomIdGenerator('doctrine.uuid_generator')]
    private ?string $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $avatar; 

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private ?string $email;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $lastName = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $firstName = null;

    #[ORM\Column(type: 'json')]
    private array $roles = ['ROLE_USER'];

    private ?string $plainPassword = null; 

    #[ORM\Column(type: 'string', length: 255)]
    private string $password;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $updatedAt;


    public function getId(): ?string
    {
        return $this->id;
    }

    
    public function getAvatar() : string
    {
        return $this->avatar;
    }


    public function setAvatar($avatar) : self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
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

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getLastName() : ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName) : self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName() : ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName) : self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getPlainPassword() : ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword) : self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getCreatedAt() : \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt) : self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt() : \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt) : self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
