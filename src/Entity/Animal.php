<?php

namespace App\Entity;

use App\Enum\AnimalType;
use App\Enum\AnimalRace;
use App\Enum\AnimalGender;
use App\Enum\AdoptionStatus;
use App\Utils\RegexPatterns;

use App\Repository\AnimalRepository;

use DateTimeImmutable;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: "Le nom est obligatoire.")]
    #[Assert\Regex(RegexPatterns::ONLY_TEXTE_REGEX)]
    #[Assert\Length(max: 50, maxMessage: "Le nom ne doit pas dépasser 50 caractères.")]
    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[Assert\NotBlank(message: "La description est obligatoire.")]
    #[Assert\Regex(RegexPatterns::FREE_TEXT_REGEX)]
    #[Assert\Length(max: 255, maxMessage: "La description ne doit pas dépasser 255 caractères.")]
    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[Assert\NotBlank(message: "Veuillez sélectionner un type.")]
    #[ORM\Column(type: Types::STRING, length: 50, enumType: AnimalType::class, nullable: false)]
    private ?AnimalType $type = null;

    #[Assert\NotBlank(message: "Veuillez sélectionner une race.")]
    #[ORM\Column(type: Types::STRING, length: 50, enumType: AnimalRace::class, nullable: false)]
    private ?AnimalRace $race = null;

    #[Assert\NotBlank(message: "Veuillez sélectionner un genre.")]
    #[ORM\Column(type: Types::STRING, length: 50, enumType: AnimalGender::class, nullable: false)]
    private ?AnimalGender $gender = null;

    #[Assert\NotNull(message: "Le statut d'adoption est obligatoire.")]
    #[ORM\Column(type: Types::STRING, length: 50, enumType: AdoptionStatus::class, nullable: false)]
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

    #[Assert\Type('DateTime')] // Assurez-vous que c'est bien une date si elle est renseignée
    #[Assert\LessThan('today', message: "La date de naissance ne peut pas être dans le futur.")]
    #[Assert\LessThan(
        propertyPath: 'arrivalDate',
        message: "La date de naissance doit être antérieure à la date d'arrivée."
    )]
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $birthday = null;

    #[Assert\Type('DateTimeImmutable')]
    #[Assert\NotBlank(message: "La date d'arrivée est obligatoire.")]
    #[Assert\LessThan('today', message: "La date d'arrivée ne peut pas être dans le futur.")]
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?DateTimeImmutable $arrivalDate = null;

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

        $this->name = ucfirst($name);

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {

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

    public function getBirthday(): ?DateTimeImmutable
    {
        return $this->birthday;
    }

    public function setBirthday(?DateTimeImmutable $birthday): static
    {

        $this->birthday = $birthday;
        return $this;
    }

    public function getArrivalDate(): ?DateTimeImmutable
    {
        return $this->arrivalDate;
    }

    public function setArrivalDate(DateTimeImmutable $arrivalDate): static
    {

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
}
