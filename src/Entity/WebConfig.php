<?php

namespace App\Entity;

use App\Repository\WebConfigRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WebConfigRepository::class)]
class WebConfig
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 32, nullable: true)]
    private ?string $colorCode = null;

    #[ORM\Column(length: 32, nullable: true)]
    private ?string $fontSize = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $priority = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getColorCode(): ?string
    {
        return $this->colorCode;
    }

    public function setColorCode(string $colorCode): static
    {
        $this->colorCode = $colorCode;

        return $this;
    }

    public function getFontSize(): ?string
    {
        return $this->fontSize;
    }

    public function setFontSize(?string $fontSize): static
    {
        $this->fontSize = $fontSize;

        return $this;
    }

    public function getPriority(): ?string
    {
        return $this->priority;
    }

    public function setPriority(?string $priority): static
    {
        $this->priority = $priority;

        return $this;
    }
}
