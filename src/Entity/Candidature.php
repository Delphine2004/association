<?php

namespace App\Entity;

use App\Enum\CandidatureStatus;
use App\Utils\RegexPatterns;

use DateTimeImmutable;
use InvalidArgumentException;

class Candidature
{

    public function __construct(
        public ?int $candidatureId = null,
        public ?CandidatureStatus $candidatureStatus = null,
        public ?string $firstName = null,
        public ?string $lastName = null,
        public ?string $email = null,
        public ?string $phone = null,
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null
    ) {

        $this->setFirstName($firstName)
            ->setLastName($lastName)
            ->setEmail($email)
            ->setPhone($phone);

        $this->createdAt = $createdAt ?? new DateTimeImmutable();
        $this->updatedAt = $updatedAt ?? new DateTimeImmutable();
    }

    // ------------- Les getters--------

    public function getCandidatureId(): ?int
    {
        return $this->candidatureId;
    }

    public function getCandidatureStatus(): ?CandidatureStatus
    {
        return $this->candidatureStatus;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }


    // ------------- Les setters--------

    public function setCandidatureStatus(?CandidatureStatus $candidatureStatus): self
    {
        $this->candidatureStatus = $candidatureStatus;
        return $this;
    }


    public function setFirstName(?string $firstName): self
    {
        if ($firstName !== null) {
            $firstName = trim($firstName);

            if (empty($firstName)) {
                throw new InvalidArgumentException("Le prénom est obligatoire.");
            }

            if (!preg_match(RegexPatterns::ONLY_TEXTE_REGEX, $firstName)) {
                throw new InvalidArgumentException("Le prénom doit être compris entre 1 et 60 caractères autorisés.");
            }
            $this->firstName = ucfirst($firstName);
        }

        return $this;
    }

    public function setLastName(?string $lastName): self
    {
        if ($lastName !== null) {
            $lastName = trim($lastName);

            if (empty($lastName)) {
                throw new InvalidArgumentException("Le nom est obligatoire.");
            }

            if (!preg_match(RegexPatterns::ONLY_TEXTE_REGEX, $lastName)) {
                throw new InvalidArgumentException("Le nom doit être compris entre 1 et 60 caractères autorisés.");
            }
            $this->lastName = strtoupper($lastName);
        } else {
            $this->lastName = null;
        }

        return $this;
    }

    public function setEmail(?string $email): self
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

        return $this;
    }

    public function setPhone(?string $phone): self
    {
        if ($phone !== null) {
            $phone = trim($phone);

            if (!preg_match(RegexPatterns::FRENCH_MOBILE_PHONE, $phone)) {
                throw new InvalidArgumentException("Le numéro de téléphone doit avoir le format téléphone portable français en 06, 07 , +33.");
            }
            $this->phone = $phone;
        } else {
            $this->phone = null;
        }
        return $this;
    }
}
