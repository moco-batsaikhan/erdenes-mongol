<?php

namespace App\Entity;

use App\Repository\CurrencyRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CurrencyRepository::class)]
class Currency
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?array $file = null;

    #[ORM\Column(nullable: true)]
    private ?array $enFile = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'currency')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CmsUser $createdUser = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $CurrencyDate = null;

    #[ORM\Column(nullable: true)]
    private ?bool $active = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFile(): ?array
    {
        return $this->file;
    }

    public function setFile(?array $file): static
    {
        $this->file = $file;

        return $this;
    }

    public function getEnFile(): ?array
    {
        return $this->enFile;
    }

    public function setEnFile(?array $enFile): static
    {
        $this->enFile = $enFile;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCreatedUser(): ?CmsUser
    {
        return $this->createdUser;
    }

    public function setCreatedUser(?CmsUser $createdUser): static
    {
        $this->createdUser = $createdUser;

        return $this;
    }

    public function getCurrencyDate(): ?\DateTimeInterface
    {
        return $this->CurrencyDate;
    }

    public function setCurrencyDate(\DateTimeInterface $CurrencyDate): static
    {
        $this->CurrencyDate = $CurrencyDate;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): static
    {
        $this->active = $active;

        return $this;
    }
}
