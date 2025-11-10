<?php

namespace App\Entity;

use App\Enum\AnimalType;
use App\Enum\AnimalRace;
use App\Enum\AnimalGender;
use App\Enum\AdoptionStatus;
use App\Utils\RegexPatterns;

use App\Repository\AnimalRepository;

use InvalidArgumentException;
use DateTimeImmutable;
use DateTime;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;


#[ORM\Entity(repositoryClass: AnimalRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: Types::STRING, length: 50, enumType: AnimalType::class)]
    private ?AnimalType $type = null;

    #[ORM\Column(type: Types::STRING, length: 50, enumType: AnimalRace::class)]
    private ?AnimalRace $race = null;

    #[ORM\Column(type: Types::STRING, length: 50, enumType: AnimalGender::class)]
    private ?AnimalGender $gender = null;

    #[ORM\Column(type: Types::STRING, length: 50, enumType: AdoptionStatus::class)]
    private ?AdoptionStatus $status = null;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    private bool $vaccinated = false;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    private bool $sterilized = false;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    private bool $chipped = false;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    private bool $compatibleKid = false;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    private bool $compatibleCat = false;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    private bool $compatibleDog = false;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?DateTime $birthday = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?DateTime $arrivalDate = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, Picture>
     */
    #[ORM\OneToMany(targetEntity: Picture::class, mappedBy: 'animal')]
    private Collection $pictures;

    /**
     * @var Collection<int, Specification>
     */
    #[ORM\ManyToMany(targetEntity: Specification::class, inversedBy: 'animals')]
    private Collection $specifications;

    /**
     * @var Collection<int, Candidature>
     */
    #[ORM\OneToMany(targetEntity: Candidature::class, mappedBy: 'animal')]
    private Collection $candidatures;


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

    public function __construct()
    {
        $this->pictures = new ArrayCollection();
        $this->specifications = new ArrayCollection();
        $this->candidatures = new ArrayCollection();
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

        $name = trim($name);

        if (empty($name)) {
            throw new InvalidArgumentException("Le nom est obligatoire.");
        }

        if (!preg_match(RegexPatterns::ONLY_TEXTE_REGEX, $name)) {
            throw new InvalidArgumentException("Le nom doit être compris entre 1 et 60 caractères autorisés.");
        }
        $this->name = strtoupper($name);

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $description = trim($description);

        if (!preg_match(RegexPatterns::FREE_TEXT_REGEX, $description)) {
            throw new InvalidArgumentException("La description peut contenir entre 2 et 255 caractères autorisés.");
        }

        $this->description = ucfirst($description);

        return $this;
    }

    public function getType(): ?AnimalType
    {
        return $this->type;
    }

    public function setType(AnimalType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getRace(): ?AnimalRace
    {
        return $this->race;
    }

    public function setRace(AnimalRace $race): static
    {
        $this->race = $race;

        return $this;
    }

    public function getGender(): ?AnimalGender
    {
        return $this->gender;
    }

    public function setGender(AnimalGender $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getStatus(): ?AdoptionStatus
    {
        return $this->status;
    }

    public function setStatus(AdoptionStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function isVaccinated(): bool
    {
        return $this->vaccinated;
    }

    public function setVaccinated(bool $vaccinated): static
    {
        $this->vaccinated = $vaccinated;

        return $this;
    }

    public function isSterilized(): bool
    {
        return $this->sterilized;
    }

    public function setSterilized(bool $sterilized): static
    {
        $this->sterilized = $sterilized;

        return $this;
    }

    public function isChipped(): bool
    {
        return $this->chipped;
    }

    public function setChipped(bool $chipped): static
    {
        $this->chipped = $chipped;

        return $this;
    }

    public function isCompatibleKid(): bool
    {
        return $this->compatibleKid;
    }

    public function setCompatibleKid(bool $compatibleKid): static
    {
        $this->compatibleKid = $compatibleKid;

        return $this;
    }

    public function isCompatibleCat(): bool
    {
        return $this->compatibleCat;
    }

    public function setCompatibleCat(bool $compatibleCat): static
    {
        $this->compatibleCat = $compatibleCat;

        return $this;
    }

    public function isCompatibleDog(): bool
    {
        return $this->compatibleDog;
    }

    public function setCompatibleDog(bool $compatibleDog): static
    {
        $this->compatibleDog = $compatibleDog;

        return $this;
    }

    public function getBirthday(): ?DateTime
    {
        return $this->birthday;
    }

    public function setBirthday(?DateTime $birthday): static
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

    public function getArrivalDate(): ?DateTime
    {
        return $this->arrivalDate;
    }

    public function setArrivalDate(DateTime $arrivalDate): static
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

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }


    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }


    /**
     * @return Collection<int, Picture>
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(Picture $picture): static
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures->add($picture);
            $picture->setAnimal($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): static
    {
        if ($this->pictures->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getAnimal() === $this) {
                $picture->setAnimal(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Specification>
     */
    public function getSpecifications(): Collection
    {
        return $this->specifications;
    }

    public function addSpecification(Specification $specification): static
    {
        if (!$this->specifications->contains($specification)) {
            $this->specifications->add($specification);
        }

        return $this;
    }

    public function removeSpecification(Specification $specification): static
    {
        $this->specifications->removeElement($specification);

        return $this;
    }

    /**
     * @return Collection<int, Candidature>
     */
    public function getCandidatures(): Collection
    {
        return $this->candidatures;
    }

    public function addCandidature(Candidature $candidature): static
    {
        if (!$this->candidatures->contains($candidature)) {
            $this->candidatures->add($candidature);
            $candidature->setAnimal($this);
        }

        return $this;
    }

    public function removeCandidature(Candidature $candidature): static
    {
        if ($this->candidatures->removeElement($candidature)) {
            // set the owning side to null (unless already changed)
            if ($candidature->getAnimal() === $this) {
                $candidature->setAnimal(null);
            }
        }

        return $this;
    }
}
