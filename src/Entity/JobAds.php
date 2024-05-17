<?php

namespace App\Entity;

use App\Repository\JobAdsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JobAdsRepository::class)]
class JobAds
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $profession = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $applicationDeadline = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $body = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $enTitle = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cnTitle = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $enProfession = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cnProfession = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $enBody = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $cnBody = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(?string $profession): static
    {
        $this->profession = $profession;

        return $this;
    }

    public function getApplicationDeadline(): ?\DateTimeInterface
    {
        return $this->applicationDeadline;
    }

    public function setApplicationDeadline(?\DateTimeInterface $applicationDeadline): static
    {
        $this->applicationDeadline = $applicationDeadline;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(?string $body): static
    {
        $this->body = $body;

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

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getEnTitle(): ?string
    {
        return $this->enTitle;
    }

    public function setEnTitle(?string $enTitle): static
    {
        $this->enTitle = $enTitle;

        return $this;
    }

    public function getCnTitle(): ?string
    {
        return $this->cnTitle;
    }

    public function setCnTitle(?string $cnTitle): static
    {
        $this->cnTitle = $cnTitle;

        return $this;
    }

    public function getEnProfession(): ?string
    {
        return $this->enProfession;
    }

    public function setEnProfession(?string $enProfession): static
    {
        $this->enProfession = $enProfession;

        return $this;
    }

    public function getCnProfession(): ?string
    {
        return $this->cnProfession;
    }

    public function setCnProfession(?string $cnProfession): static
    {
        $this->cnProfession = $cnProfession;

        return $this;
    }

    public function getEnBody(): ?string
    {
        return $this->enBody;
    }

    public function setEnBody(?string $enBody): static
    {
        $this->enBody = $enBody;

        return $this;
    }

    public function getCnBody(): ?string
    {
        return $this->cnBody;
    }

    public function setCnBody(?string $cnBody): static
    {
        $this->cnBody = $cnBody;

        return $this;
    }
}
