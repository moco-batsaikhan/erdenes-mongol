<?php

namespace App\Entity;

use App\Repository\MapRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MapRepository::class)]
class Map
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 16)]
    private ?string $dataType = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'map')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CmsUser $createdUser = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?float $latitude = null;

    #[ORM\Column(nullable: true)]
    private ?float $longitude = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $enDescription = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $mnBody = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $mnDescription = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $cnDescription = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $enBody = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $cnBody = null;

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

    public function getDataType(): ?string
    {
        return $this->dataType;
    }

    public function setDataType(string $dataType): static
    {
        $this->dataType = $dataType;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): static
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

    public function getCreatedUser(): ?CmsUser
    {
        return $this->createdUser;
    }

    public function setCreatedUser(?CmsUser $createdUser): static
    {
        $this->createdUser = $createdUser;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getEnDescription(): ?string
    {
        return $this->enDescription;
    }

    public function setEnDescription(?string $enDescription): static
    {
        $this->enDescription = $enDescription;

        return $this;
    }

    public function getMnBody(): ?string
    {
        return $this->mnBody;
    }

    public function setMnBody(?string $mnBody): static
    {
        $this->mnBody = $mnBody;

        return $this;
    }

    public function getMnDescription(): ?string
    {
        return $this->mnDescription;
    }

    public function setMnDescription(?string $mnDescription): static
    {
        $this->mnDescription = $mnDescription;

        return $this;
    }

    public function getCnDescription(): ?string
    {
        return $this->cnDescription;
    }

    public function setCnDescription(?string $cnDescription): static
    {
        $this->cnDescription = $cnDescription;

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
