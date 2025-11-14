<?php

namespace App\Entity;

use App\Utils\RegexPatterns;

use App\Repository\EventRepository;

use DateTimeImmutable;
use DateTimeInterface; // uniquement la date
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Type('DateTimeInterface')]
    #[Assert\NotBlank(message: "La date de l'événement est obligatoire.")]
    #[Assert\GreaterThanOrEqual('today', message: "La date de l'événement ne peut pas être dans le passé.")]
    #[ORM\Column(type: 'date')]
    private ?DateTimeInterface $date = null;


    #[Assert\NotBlank(message: "L'endroit de l'événement est obligatoire.")]
    #[Assert\Regex(RegexPatterns::ONLY_TEXTE_REGEX)]
    #[Assert\Length(max: 100, maxMessage: "L'endroit ne doit pas dépasser 100 caractères.")]
    #[ORM\Column(length: 100)]
    private ?string $place = null;

    #[Assert\NotBlank(message: "La description est obligatoire.")]
    #[Assert\Length(min: 20, minMessage: "La description doit contenir au moins 20 caractères.")]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'events')]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }


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


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(string $place): static
    {
        $this->place = $place;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

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
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addEvent($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeEvent($this);
        }

        return $this;
    }
}
