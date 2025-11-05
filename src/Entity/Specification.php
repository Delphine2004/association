<?php

namespace App\Entity;

use App\Enum\SpecificationCategory;
use App\Utils\RegexPatterns;

use InvalidArgumentException;

class Specification
{

    public function __construct(
        public ?int $specificationId = null,
        public ?string $specificationName = null,
        public ?SpecificationCategory $specificationCategory = null

    ) {
        $this->setSpecificationName($specificationName)
            ->setSpecificationCategory($specificationCategory);
    }

    // ------------- Les getters--------

    public function getSpecificationName(): ?string
    {
        return $this->specificationName;
    }

    public function getSpecificationCategory(): ?SpecificationCategory
    {
        return $this->specificationCategory;
    }


    // ------------- Les setters--------

    public function setSpecificationName(?string $specificationName): self
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

    public function setSpecificationCategory(?SpecificationCategory $specificationCategory): self
    {
        $this->specificationCategory = $specificationCategory;
        return $this;
    }
}
