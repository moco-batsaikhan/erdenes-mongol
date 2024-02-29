<?php

namespace App\Entity;

use App\Repository\ResolutionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResolutionRepository::class)]
class Resolution
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mnTenderName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $enTenderName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cnTenderName = null;

    #[ORM\Column(length: 255)]
    private ?string $subscriber = null;

    #[ORM\Column(nullable: true)]
    private ?int $tenderId = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $announcedDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $closingDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $redirectLink = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $body = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMnTenderName(): ?string
    {
        return $this->mnTenderName;
    }

    public function setMnTenderName(?string $mnTenderName): static
    {
        $this->mnTenderName = $mnTenderName;

        return $this;
    }

    public function getEnTenderName(): ?string
    {
        return $this->enTenderName;
    }

    public function setEnTenderName(?string $enTenderName): static
    {
        $this->enTenderName = $enTenderName;

        return $this;
    }

    public function getCnTenderName(): ?string
    {
        return $this->cnTenderName;
    }

    public function setCnTenderName(?string $cnTenderName): static
    {
        $this->cnTenderName = $cnTenderName;

        return $this;
    }

    public function getSubscriber(): ?string
    {
        return $this->subscriber;
    }

    public function setSubscriber(string $subscriber): static
    {
        $this->subscriber = $subscriber;

        return $this;
    }

    public function getTenderId(): ?int
    {
        return $this->tenderId;
    }

    public function setTenderId(?int $tenderId): static
    {
        $this->tenderId = $tenderId;

        return $this;
    }

    public function getAnnouncedDate(): ?\DateTimeInterface
    {
        return $this->announcedDate;
    }

    public function setAnnouncedDate(?\DateTimeInterface $announcedDate): static
    {
        $this->announcedDate = $announcedDate;

        return $this;
    }

    public function getClosingDate(): ?\DateTimeInterface
    {
        return $this->closingDate;
    }

    public function setClosingDate(?\DateTimeInterface $closingDate): static
    {
        $this->closingDate = $closingDate;

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

    public function getRedirectLink(): ?string
    {
        return $this->redirectLink;
    }

    public function setRedirectLink(?string $redirectLink): static
    {
        $this->redirectLink = $redirectLink;

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
}
