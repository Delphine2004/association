<?php

namespace App\Entity;

use App\Enum\SpecificationCategory;
use App\Utils\RegexPatterns;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use InvalidArgumentException;

use App\Repository\SpecificationRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: SpecificationRepository::class)]
class Specification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(type: Types::STRING, length: 50, enumType: SpecificationCategory::class, nullable: true)]
    private ?SpecificationCategory $category = null;

    /**
     * @var Collection<int, Animal>
     */
    #[ORM\ManyToMany(targetEntity: Animal::class, mappedBy: 'specifications')]
    private Collection $animals;

    public function __construct()
    {
        $this->animals = new ArrayCollection();
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
        $this->name = ucfirst($name);


        return $this;
    }

    public function getCategory(): ?SpecificationCategory
    {
        return $this->category;
    }

    public function getCategoryValue(): ?string
    {
        return $this->category?->value;
    }

    public function setCategory(?SpecificationCategory $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Animal>
     */
    public function getAnimals(): Collection
    {
        return $this->animals;
    }

    public function addAnimal(Animal $animal): static
    {
        if (!$this->animals->contains($animal)) {
            $this->animals->add($animal);
            $animal->addSpecification($this);
        }

        return $this;
    }

    public function removeAnimal(Animal $animal): static
    {
        if ($this->animals->removeElement($animal)) {
            $animal->removeSpecification($this);
        }

        return $this;
    }
}
