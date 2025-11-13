<?php

namespace App\Entity;

use App\Enum\SpecificationCategory;
use App\Utils\RegexPatterns;

use App\Repository\SpecificationRepository;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpecificationRepository::class)]
class Specification
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

    #[Assert\NotBlank(message: "Veuillez sélectionner une catégorie.")]
    #[ORM\Column(type: Types::STRING, length: 50, enumType: SpecificationCategory::class, nullable: false)]
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
