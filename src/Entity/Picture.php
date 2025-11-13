<?php

namespace App\Entity;

use App\Repository\PictureRepository;

use DateTimeImmutable;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PictureRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Picture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: "L'URL de l'image est obligatoire.")]
    #[Assert\Length(max: 255, maxMessage: "L'URL ne doit pas dépasser 255 caractères.")]
    #[Assert\Url(message: "L'URL '{{ value }}' n'est pas une URL valide.")]
    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\Column(type: Types::BOOLEAN,  options: ['default' => false])]
    private bool $main = false;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $createdAt = null;

    #[Assert\NotBlank(message: "L'image doit être associée à un animal.")]
    #[ORM\ManyToOne(inversedBy: 'pictures')]
    private ?Animal $animal = null;

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->createdAt = new DateTimeImmutable();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function isMain(): bool
    {
        return $this->main;
    }

    public function setMain(bool $main): static
    {
        $this->main = $main;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function setAnimal(?Animal $animal): static
    {
        $this->animal = $animal;

        return $this;
    }
}
