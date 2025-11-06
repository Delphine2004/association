<?php

namespace App\Entity;

use App\Enum\SpecificationCategory;
use App\Utils\RegexPatterns;

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

    public function getSpecificationCategory(): ?string
    {
        return $this->specificationCategory;
    }

    public function setSpecificationCategory(?SpecificationCategory $specificationCategory): static
    {
        $this->specificationCategory = $specificationCategory;

        return $this;
    }
}
