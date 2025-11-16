<?php

namespace App\Entity;

use App\Enum\UserRole;
use App\Repository\UserRepository;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'Cet email est déjà utilisé.')]
#[ORM\HasLifecycleCallbacks]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: "Ce champ est obligatoire.")]
    #[Assert\Email(message: "Email invalide")]
    #[Assert\Length(max: 255, maxMessage: "L'email ne doit pas dépasser 255 caractères.")]
    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;

    // Validation faite dans le type
    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[Assert\NotNull(message: "Veuillez sélectionner un rôle.")]
    #[ORM\Column(type: Types::STRING, length: 50, enumType: UserRole::class)]
    private ?UserRole $role = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $updatedAt = null;


    #[ORM\OneToMany(targetEntity: Animal::class, mappedBy: 'createdBy')]
    private Collection $animalsCreated;

    #[ORM\OneToMany(targetEntity: Animal::class, mappedBy: 'updatedBy')]
    private Collection $animalsUpdated;

    #[ORM\OneToMany(targetEntity: Event::class, mappedBy: 'createdBy')]
    private Collection $eventsCreated;

    #[ORM\OneToMany(targetEntity: Event::class, mappedBy: 'updatedBy')]
    private Collection $eventsUpdated;


    public function __construct()
    {
        $this->animalsCreated = new ArrayCollection();
        $this->animalsUpdated = new ArrayCollection();
        $this->eventsCreated = new ArrayCollection();
        $this->eventsUpdated = new ArrayCollection();
    }


    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?UserRole
    {
        return $this->role;
    }

    public function getRoleValue(): ?string
    {
        return $this->role?->value;
    }

    public function getRoles(): array
    {
        $roles = ($this->role) ? [$this->role->value] : [];

        $roles[] = 'ROLE_USER'; // rôle requis par symfony

        return array_unique($roles);
    }

    public function setRole(UserRole $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }


    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function getAnimalsCreated(): Collection
    {
        return $this->animalsCreated;
    }

    public function getAnimalsUpdated(): Collection
    {
        return $this->animalsUpdated;
    }

    public function getEventsCreated(): Collection
    {
        return $this->eventsCreated;
    }

    public function getEventsUpdated(): Collection
    {
        return $this->eventsUpdated;
    }

    // ----- Méthodes de vérification -----

    // ne pas supprimer car fait partie de UserInterface
    public function eraseCredentials(): void {}
}
