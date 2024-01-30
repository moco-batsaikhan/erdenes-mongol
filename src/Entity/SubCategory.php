<?php

namespace App\Entity;

use App\Repository\SubCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubCategoryRepository::class)]
class SubCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 32)]
    private ?string $mnName = null;

    #[ORM\Column(length: 32, nullable: true)]
    private ?string $cnName = null;

    #[ORM\Column(length: 32)]
    private ?string $enName = null;

    #[ORM\Column(nullable: true)]
    private ?int $priority = null;

    #[ORM\Column(length: 16, nullable: true)]
    private ?string $opentype = null;

    #[ORM\Column(nullable: true)]
    private ?bool $active = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'yes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CmsUser $createdUser = null;

    #[ORM\ManyToOne(inversedBy: 'yes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MainCategory $mainCategoryId = null;

    #[ORM\Column(length: 255)]
    private ?string $clickType = null;

    #[ORM\ManyToOne(inversedBy: 'subCategories')]
    private ?NewsType $newsTypeId = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMnName(): ?string
    {
        return $this->mnName;
    }

    public function setMnName(string $mnName): static
    {
        $this->mnName = $mnName;

        return $this;
    }

    public function getCnName(): ?string
    {
        return $this->cnName;
    }

    public function setCnName(?string $cnName): static
    {
        $this->cnName = $cnName;

        return $this;
    }

    public function getEnName(): ?string
    {
        return $this->enName;
    }

    public function setEnName(string $enName): static
    {
        $this->enName = $enName;

        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(?int $priority): static
    {
        $this->priority = $priority;

        return $this;
    }

    public function getOpentype(): ?string
    {
        return $this->opentype;
    }

    public function setOpentype(?string $opentype): static
    {
        $this->opentype = $opentype;

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

    public function getMainCategoryId(): ?MainCategory
    {
        return $this->mainCategoryId;
    }

    public function setMainCategoryId(?MainCategory $mainCategoryId): static
    {
        $this->mainCategoryId = $mainCategoryId;

        return $this;
    }

    public function getClickType(): ?string
    {
        return $this->clickType;
    }

    public function setClickType(string $clickType): static
    {
        $this->clickType = $clickType;

        return $this;
    }

    public function getNewsTypeId(): ?NewsType
    {
        return $this->newsTypeId;
    }

    public function setNewsTypeId(?NewsType $newsTypeId): static
    {
        $this->newsTypeId = $newsTypeId;

        return $this;
    }
}
