<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class AnimalSearchCriteria
{
    #[Assert\Type('digit')]
    public ?string $id = null;

    #[Assert\Length(min: 2, max: 50)]
    public ?string $name = null;

    public ?string $status = null;
    public ?string $gender = null;
    public ?string $type = null;
    public ?string $race = null;

    public ?bool $notVaccinated = null;
    public ?bool $notSterilized = null;
    public ?bool $compatibleKid = null;
    public ?bool $compatibleCat = null;
    public ?bool $compatibleDog = null;
}
