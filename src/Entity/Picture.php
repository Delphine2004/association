<?php

namespace App\Entity;

use DateTimeImmutable;
use InvalidArgumentException;

class Picture
{

    public function __construct(
        public ?int $pictureId = null,
        public ?string $pictureUrl = null,
        public ?bool $isMain = null,
        public ?DateTimeImmutable $createdAt = null,
    ) {
        $this->setPictureUrl($pictureUrl)
            ->setMain($isMain);

        $this->createdAt = $createdAt ?? new DateTimeImmutable();
    }

    // ------------- Les getters--------

    public function getPictureId(): ?int
    {
        return $this->pictureId;
    }

    public function getPictureUrl(): ?string
    {
        return $this->pictureUrl;
    }

    public function getMain(): ?bool
    {
        return $this->isMain;
    }

    // ------------- Les setters--------


    public function setPictureUrl(?string $pictureUrl): self
    {
        if ($pictureUrl !== null) {
            if (!preg_match('#^/uploads(/[\w-]+)*\.(jpg|jpeg|png|gif|webp)$#i', $pictureUrl)) {
                throw new InvalidArgumentException("Le chemin de l'image est invalide.");
            }
            $this->pictureUrl = $pictureUrl;
        } else {
            $this->pictureUrl = null;
        }
        return $this;
    }

    public function setMain(?bool $isMain): self
    {
        $this->isMain = $isMain;
        return $this;
    }
}
