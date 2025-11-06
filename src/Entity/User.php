<?php

namespace App\Entity;

use App\Repository\UserRepository;
use App\Enum\UserRole;

use App\Utils\RegexPatterns;

use InvalidArgumentException;
use DateTimeImmutable;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(type: 'string', length: 50, enumType: UserRole::class)]
    private ?UserRole $role = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    private bool $isFromDatabase = false;

    public function __construct()
    {
        if ($this->createdAt === null) {
            $this->createdAt = new \DateTimeImmutable();
        }

        if ($this->updatedAt === null) {
            $this->updatedAt = $this->createdAt;
        }
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
        if ($email !== null) {
            $email = trim($email);

            if (empty($email)) {
                throw new InvalidArgumentException("L'email est obligatoire. ");
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new InvalidArgumentException("L'email est invalide.");
            }
            $this->email = strtolower($email);
        } else {
            $this->email = null;
        }

        $this->updateTimestamp();
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password, bool $isHashed = false): static
    {
        if ($password === null) {
            $this->password = null;
            return $this;
        }

        $passwordToStore = trim($password);


        if (!$isHashed) {
            $this->validatePassword($passwordToStore);
            $passwordToStore = password_hash($passwordToStore, PASSWORD_DEFAULT);
        }

        $this->password = $passwordToStore;
        $this->updateTimestamp();
        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function getRoles(): array
    {
        $roles = ($this->role) ? [$this->role->value] : [];

        // Assurez-vous qu'au moins 'ROLE_USER' est toujours présent
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRole(UserRole $role): static
    {
        $this->role = $role;
        $this->updateTimestamp();
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }


    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }


    // ----- Méthodes de vérification -----

    // ne pas supprimer car fait partie de UserInterface
    public function eraseCredentials(): void {}

    private function validatePassword(string $password): void
    {
        $password = trim($password);

        if (!preg_match(RegexPatterns::PASSWORD, $password)) {

            throw new InvalidArgumentException('Le mot de passe doit contenir au minimun une minuscule, une majuscule, un chiffre, un caractère spécial et contenir 12 caractéres au total.');
        };
    }

    // ---- Mise à jour de la date de modification

    protected function updateTimestamp(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }
}
