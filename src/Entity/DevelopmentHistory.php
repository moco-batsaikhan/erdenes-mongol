<?php

namespace App\Entity;

use App\Repository\DevelopmentHistoryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DevelopmentHistoryRepository::class)]
class DevelopmentHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $priority = null;

    #[ORM\ManyToOne(inversedBy: 'developmentHistory')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CmsUser $createdUser = null;

    #[ORM\Column(length: 4)]
    private ?string $year = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private $data = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private $enData = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): static
    {
        $this->priority = $priority;

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


    public function getYear(): ?string
    {
        return $this->year;
    }

    public function setYear(string $year): static
    {
        $this->year = $year;

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

    public function getData(): ?array
    {
        return $this->data;
    }

    public function setData(?array $data): static
    {
        $this->data = $data;

        return $this;
    }

    public function getEnData(): ?array
    {
        return $this->enData;
    }

    public function setEnData(?array $enData): static
    {
        $this->enData = $enData;

        return $this;
    }
}
