<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use App\Enum\AnimalType;
use App\Enum\AnimalRace;
use App\Enum\AnimalGender;
use App\Enum\AdoptionStatus;
use App\Utils\RegexPatterns;

use InvalidArgumentException;
use DateTimeImmutable;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: 'string', length: 20, enumType: AnimalType::class)]
    private ?AnimalType $type = null;

    #[ORM\Column(type: 'string', length: 20, enumType: AnimalRace::class)]
    private ?AnimalRace $race = null;

    #[ORM\Column(type: 'string', length: 20, enumType: AnimalGender::class)]
    private ?AnimalGender $gender = null;

    #[ORM\Column(type: 'string', length: 20, enumType: AdoptionStatus::class)]
    private ?AdoptionStatus $adoptionStatus = null;

    #[ORM\Column]
    private ?bool $vaccinated = null;

    #[ORM\Column]
    private ?bool $sterilized = null;

    #[ORM\Column]
    private ?bool $chipped = null;

    #[ORM\Column]
    private ?bool $compatibleKid = null;

    #[ORM\Column]
    private ?bool $compatibleCat = null;

    #[ORM\Column]
    private ?bool $compatibleDog = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $birthday = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $arrivalDate = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(AnimalType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getRace(): ?string
    {
        return $this->race;
    }

    public function setRace(AnimalRace $race): static
    {
        $this->race = $race;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(AnimalGender $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getAdoptionStatus(): ?string
    {
        return $this->adoptionStatus;
    }

    public function setAdoptionStatus(AdoptionStatus $adoptionStatus): static
    {
        $this->adoptionStatus = $adoptionStatus;

        return $this;
    }

    public function isVaccinated(): ?bool
    {
        return $this->vaccinated;
    }

    public function setVaccinated(bool $vaccinated): static
    {
        $this->vaccinated = $vaccinated;
        $this->updateTimestamp();
        return $this;
    }

    public function isSterilized(): ?bool
    {
        return $this->sterilized;
    }

    public function setSterilized(bool $sterilized): static
    {
        $this->sterilized = $sterilized;
        $this->updateTimestamp();
        return $this;
    }

    public function isChipped(): ?bool
    {
        return $this->chipped;
    }

    public function setChipped(bool $chipped): static
    {
        $this->chipped = $chipped;
        $this->updateTimestamp();
        return $this;
    }

    public function isCompatibleKid(): ?bool
    {
        return $this->compatibleKid;
    }

    public function setCompatibleKid(bool $compatibleKid): static
    {
        $this->compatibleKid = $compatibleKid;
        $this->updateTimestamp();
        return $this;
    }

    public function isCompatibleCat(): ?bool
    {
        return $this->compatibleCat;
    }

    public function setCompatibleCat(bool $compatibleCat): static
    {
        $this->compatibleCat = $compatibleCat;
        $this->updateTimestamp();
        return $this;
    }

    public function isCompatibleDog(): ?bool
    {
        return $this->compatibleDog;
    }

    public function setCompatibleDog(bool $compatibleDog): static
    {
        $this->compatibleDog = $compatibleDog;
        $this->updateTimestamp();
        return $this;
    }

    public function getBirthday(): ?\DateTime
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTime $birthday): static
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

    public function getArrivalDate(): ?\DateTime
    {
        return $this->arrivalDate;
    }

    public function setArrivalDate(\DateTime $arrivalDate): static
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }


    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    // ---- Mise à jour de la date de modification
    private function updateTimestamp(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }
}
