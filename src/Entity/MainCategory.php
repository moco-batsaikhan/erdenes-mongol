<?php

namespace App\Entity;

use App\Repository\MainCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MainCategoryRepository::class)]
class MainCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 36, nullable: true)]
    private ?string $mnName = null;

    #[ORM\Column(length: 36, nullable: true)]
    private ?string $cnName = null;

    #[ORM\Column(length: 36, nullable: true)]
    private ?string $enName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $icon = null;

    #[ORM\Column(length: 36, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(nullable: true)]
    private ?int $priority = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $url = null;

    #[ORM\Column(nullable: true)]
    private ?bool $active = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'mainCategories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CmsUser $createdUser = null;

    #[ORM\OneToMany(mappedBy: 'mainCategoryId', targetEntity: SubCategory::class, orphanRemoval: true)]
    private Collection $yes;

    #[ORM\OneToMany(mappedBy: 'mainCategory', targetEntity: CategoryClick::class, orphanRemoval: true)]
    private Collection $categoryClicks;

    public function __construct()
    {
        $this->yes = new ArrayCollection();
        $this->categoryClicks = new ArrayCollection();
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

    public function setMnName(?string $mnName): static
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

    public function setEnName(?string $enName): static
    {
        $this->enName = $enName;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;

        return $this;
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

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(?int $priority): static
    {
        $this->priority = $priority;

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

    /**
     * @return Collection<int, SubCategory>
     */
    public function getYes(): Collection
    {
        return $this->yes;
    }

    public function addYe(SubCategory $ye): static
    {
        if (!$this->yes->contains($ye)) {
            $this->yes->add($ye);
            $ye->setMainCategoryId($this);
        }

        return $this;
    }

    public function removeYe(SubCategory $ye): static
    {
        if ($this->yes->removeElement($ye)) {
            // set the owning side to null (unless already changed)
            if ($ye->getMainCategoryId() === $this) {
                $ye->setMainCategoryId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CategoryClick>
     */
    public function getCategoryClicks(): Collection
    {
        return $this->categoryClicks;
    }

    public function addCategoryClick(CategoryClick $categoryClick): static
    {
        if (!$this->categoryClicks->contains($categoryClick)) {
            $this->categoryClicks->add($categoryClick);
            $categoryClick->setMainCategory($this);
        }

        return $this;
    }

    public function removeCategoryClick(CategoryClick $categoryClick): static
    {
        if ($this->categoryClicks->removeElement($categoryClick)) {
            // set the owning side to null (unless already changed)
            if ($categoryClick->getMainCategory() === $this) {
                $categoryClick->setMainCategory(null);
            }
        }

        return $this;
    }
}
