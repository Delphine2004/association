<?php

namespace App\Entity;

use App\Enum\SpecificationCategory;
use App\Utils\RegexPatterns;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use InvalidArgumentException;

use App\Repository\SpecificationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpecificationRepository::class)]
class Specification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $specificationName = null;

    #[ORM\Column(type: 'string', length: 50, enumType: SpecificationCategory::class, nullable: true)]
    private ?string $specificationCategory = null;

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

    public function getSpecificationName(): ?string
    {
        return $this->specificationName;
    }

    public function setSpecificationName(string $specificationName): static
    {
        if ($specificationName !== null) {
            $specificationName = trim($specificationName);

            if (empty($specificationName)) {
                throw new InvalidArgumentException("Le nom est obligatoire.");
            }

            if (!preg_match(RegexPatterns::ONLY_TEXTE_REGEX, $specificationName)) {
                throw new InvalidArgumentException("Le nom doit être compris entre 1 et 60 caractères autorisés.");
            }
            $this->specificationName = ucfirst($specificationName);
        }

        return $this;
    }

    public function getSpecificationCategory(): ?SpecificationCategory
    {
        return $this->specificationCategory;
    }

    public function getSpecificationCategoryValue(): ?string
    {
        return $this->specificationCategory?->value;
    }

    public function setSpecificationCategory(?SpecificationCategory $specificationCategory): static
    {
        $this->specificationCategory = $specificationCategory;

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
