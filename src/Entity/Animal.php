<?php

namespace App\Entity;

use App\Enum\AnimalType;
use App\Enum\AnimalRace;
use App\Enum\AnimalGender;
use App\Enum\AdoptionStatus;
use App\Utils\RegexPatterns;

use DateTimeImmutable;
use InvalidArgumentException;

class Animal
{

    public function __construct(
        public ?int $animalId = null,

        public ?string $name = null,
        public ?string $description = null,

        public ?AnimalType $type = null,
        public ?AnimalRace $race = null,
        public ?AnimalGender $gender = null,
        public ?AdoptionStatus $adoptionStatus = null,

        public ?bool $isVaccinated = null,
        public ?bool $isSterilized = null,
        public ?bool $isChipped = null,
        public ?bool $isCompatibleKid = null,
        public ?bool $isCompatibleCat = null,
        public ?bool $isCompatibleDog = null,

        public ?DateTimeImmutable $birthday = null,
        public ?DateTimeImmutable $arrivalDate = null,

        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null
    ) {
        $this->setName($name)
            ->setDescription($description)
            ->setType($type)
            ->setRace($race)
            ->setGender($gender)
            ->setAdoptionStatus($adoptionStatus)
            ->setChipped($isChipped)
            ->setVaccination($isVaccinated)
            ->setSterilization($isSterilized)
            ->setCompatibleKid($isCompatibleKid)
            ->setCompatibleCat($isCompatibleCat)
            ->setCompatibleDog($isCompatibleDog)
            ->setBirthday($birthday)
            ->setArrivalDate($arrivalDate);

        $this->createdAt = $createdAt ?? new DateTimeImmutable();
        $this->updatedAt = $updatedAt ?? new DateTimeImmutable();
    }

    // ------------- Les getters--------

    public function getAnimalId(): ?int
    {
        return $this->animalId;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getType(): ?AnimalType
    {
        return $this->type;
    }

    public function getRace(): ?AnimalRace
    {
        return $this->race;
    }

    public function getGender(): ?AnimalGender
    {
        return $this->gender;
    }

    public function getAdoptionStatus(): ?AdoptionStatus
    {
        return $this->adoptionStatus;
    }

    public function getChipped(): ?bool
    {
        return $this->isChipped;
    }

    public function getVaccinated(): ?bool
    {
        return $this->isVaccinated;
    }

    public function getSterilized(): ?bool
    {
        return $this->isSterilized;
    }

    public function getCompatibleKid(): ?bool
    {
        return $this->isCompatibleKid;
    }

    public function getCompatibleCat(): ?bool
    {
        return $this->isCompatibleCat;
    }

    public function getCompatibleDog(): ?bool
    {
        return $this->isCompatibleDog;
    }


    public function getBirthday(): ?DateTimeImmutable
    {
        return $this->birthday;
    }

    public function getArrivalDate(): ?DateTimeImmutable
    {
        return $this->arrivalDate;
    }

    // ------------- Les setters--------


    public function setName(?string $name): self
    {
        if ($name !== null) {
            $name = trim($name);

            if (empty($name)) {
                throw new InvalidArgumentException("Le nom est obligatoire.");
            }

            if (!preg_match(RegexPatterns::ONLY_TEXTE_REGEX, $name)) {
                throw new InvalidArgumentException("Le nom doit être compris entre 1 et 60 caractères autorisés.");
            }
            $this->name = strtoupper($name);
        } else {
            $this->name = null;
        }

        $this->updateTimestamp();
        return $this;
    }

    public function setDescription(?string $description): self
    {

        if ($description !== null) {
            $description = trim($description);

            if (!preg_match(RegexPatterns::FREE_TEXT_REGEX, $description)) {
                throw new InvalidArgumentException("La description peut contenir entre 2 et 255 caractères autorisés.");
            }
        }

        $this->description = ucfirst($description);
        $this->updateTimestamp();
        return $this;
    }

    public function setType(?AnimalType $type): self
    {
        $this->type = $type;
        $this->updateTimestamp();
        return $this;
    }

    public function setRace(?AnimalRace $race): self
    {
        $this->race = $race;
        $this->updateTimestamp();
        return $this;
    }

    public function setGender(?AnimalGender $gender): self
    {
        $this->gender = $gender;
        $this->updateTimestamp();
        return $this;
    }

    public function setAdoptionStatus(?AdoptionStatus $adoptionStatus): self
    {
        $this->adoptionStatus = $adoptionStatus;
        $this->updateTimestamp();
        return $this;
    }

    public function setChipped(?bool $isChipped): self
    {
        $this->isChipped = $isChipped;
        $this->updateTimestamp();
        return $this;
    }

    public function setVaccination(?bool $isVaccinated): self
    {
        $this->isVaccinated = $isVaccinated;
        $this->updateTimestamp();
        return $this;
    }

    public function setSterilization(?bool $isSterilized): self
    {
        $this->isSterilized = $isSterilized;
        $this->updateTimestamp();
        return $this;
    }

    public function setCompatibleKid(?bool $isCompatibleKid): self
    {
        $this->isCompatibleKid = $isCompatibleKid;
        $this->updateTimestamp();
        return $this;
    }

    public function setCompatibleCat(?bool $isCompatibleCat): self
    {
        $this->isCompatibleCat = $isCompatibleCat;
        $this->updateTimestamp();
        return $this;
    }

    public function setCompatibleDog(?bool $isCompatibleDog): self
    {
        $this->isCompatibleDog = $isCompatibleDog;
        $this->updateTimestamp();
        return $this;
    }

    public function setBirthday(?DateTimeImmutable $birthday): self
    {
        if ($birthday !== null) {
            $today = new DateTimeImmutable('today');
            if ($birthday > $today) {
                throw new InvalidArgumentException(" La date ne peut pas être dans le futur.");
            }
        }
        $this->birthday = $birthday;
        return $this;
    }

    public function setArrivalDate(?DateTimeImmutable $arrivalDate): self
    {
        if ($arrivalDate !== null) {
            $today = new DateTimeImmutable('today');
            if ($arrivalDate > $today) {
                throw new InvalidArgumentException(" La date ne peut pas être dans le futur.");
            }

            if ($this->birthday !== null && $arrivalDate < $this->birthday) {
                throw new InvalidArgumentException("La date d'arrivée ne peut pas être antérieure à la date de naissance.");
            }
        }
        $this->arrivalDate = $arrivalDate;
        return $this;
    }


    // ---- Mise à jour de la date de modification
    private function updateTimestamp(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }
}
