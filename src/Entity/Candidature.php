<?php

namespace App\Entity;

use App\Enum\CandidatureStatus;
use App\Utils\RegexPatterns;
use App\Repository\CandidatureRepository;

use DateTimeImmutable;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: CandidatureRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Candidature
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 50, enumType: CandidatureStatus::class)]
    private ?CandidatureStatus $status = null;

    #[ORM\Column(length: 50)]
    private ?string $firstName = null;

    #[ORM\Column(length: 50)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 20)]
    private ?string $phone = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'candidatures')]
    private ?Animal $animal = null;


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

    public function getStatus(): ?CandidatureStatus
    {
        return $this->status;
    }

    public function setStatus(CandidatureStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        if (null !== $firstName) {
            $firstName = trim($firstName);

            if (empty($firstName)) {
                throw new \InvalidArgumentException('Le prénom est obligatoire.');
            }

            if (!preg_match(RegexPatterns::ONLY_TEXTE_REGEX, $firstName)) {
                throw new \InvalidArgumentException('Le prénom doit être compris entre 1 et 60 caractères autorisés.');
            }
            $this->firstName = ucfirst($firstName);
        }

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        if (null !== $lastName) {
            $lastName = trim($lastName);

            if (empty($lastName)) {
                throw new \InvalidArgumentException('Le nom est obligatoire.');
            }

            if (!preg_match(RegexPatterns::ONLY_TEXTE_REGEX, $lastName)) {
                throw new \InvalidArgumentException('Le nom doit être compris entre 1 et 60 caractères autorisés.');
            }
            $this->lastName = strtoupper($lastName);
        } else {
            $this->lastName = null;
        }

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        if (null !== $email) {
            $email = trim($email);

            if (empty($email)) {
                throw new \InvalidArgumentException("L'email est obligatoire. ");
            }

            if (!filter_var($email, \FILTER_VALIDATE_EMAIL)) {
                throw new \InvalidArgumentException("L'email est invalide.");
            }
            $this->email = strtolower($email);
        } else {
            $this->email = null;
        }

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        if (null !== $phone) {
            $phone = trim($phone);

            if (!preg_match(RegexPatterns::FRENCH_MOBILE_PHONE, $phone)) {
                throw new \InvalidArgumentException('Le numéro de téléphone doit avoir le format téléphone portable français en 06, 07 , +33.');
            }
            $this->phone = $phone;
        } else {
            $this->phone = null;
        }

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

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function setAnimal(?Animal $animal): static
    {
        $this->animal = $animal;

        return $this;
    }
}
