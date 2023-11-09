<?php

namespace App\Entity;

use App\Repository\NewsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NewsRepository::class)]
class News
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $enTitle = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mnTitle = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cnTitle = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isSpecial = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageUrl = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mnHeadline = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $enHeadline = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cnHeadline = null;

    #[ORM\ManyToOne(inversedBy: 'news')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CmsUser $createdUser = null;

    #[ORM\OneToMany(mappedBy: 'news', targetEntity: ContentConnection::class, orphanRemoval: true)]
    private Collection $contentConnections;

    #[ORM\OneToMany(mappedBy: 'news', targetEntity: CategoryClick::class, orphanRemoval: true)]
    private Collection $categoryClicks;

    public function __construct()
    {
        $this->contentConnections = new ArrayCollection();
        $this->categoryClicks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMnTitle(): ?string
    {
        return $this->mnTitle;
    }

    public function setMnTitle(?string $mnTitle): static
    {
        $this->mnTitle = $mnTitle;

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

    public function isIsSpecial(): ?bool
    {
        return $this->isSpecial;
    }

    public function setIsSpecial(?bool $isSpecial): static
    {
        $this->isSpecial = $isSpecial;

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

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(?string $imageUrl): static
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function getMnHeadline(): ?string
    {
        return $this->mnHeadline;
    }

    public function setMnHeadline(?string $mnHeadline): static
    {
        $this->mnHeadline = $mnHeadline;

        return $this;
    }

    public function getEnHeadline(): ?string
    {
        return $this->enHeadline;
    }

    public function setEnHeadline(?string $enHeadline): static
    {
        $this->enHeadline = $enHeadline;

        return $this;
    }

    public function getCnHeadline(): ?string
    {
        return $this->cnHeadline;
    }

    public function setCnHeadline(?string $cnHeadline): static
    {
        $this->cnHeadline = $cnHeadline;

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
     * @return Collection<int, ContentConnection>
     */
    public function getContentConnections(): Collection
    {
        return $this->contentConnections;
    }

    public function addContentConnection(ContentConnection $contentConnection): static
    {
        if (!$this->contentConnections->contains($contentConnection)) {
            $this->contentConnections->add($contentConnection);
            $contentConnection->setNews($this);
        }

        return $this;
    }

    public function removeContentConnection(ContentConnection $contentConnection): static
    {
        if ($this->contentConnections->removeElement($contentConnection)) {
            // set the owning side to null (unless already changed)
            if ($contentConnection->getNews() === $this) {
                $contentConnection->setNews(null);
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
            $categoryClick->setNews($this);
        }

        return $this;
    }

    public function removeCategoryClick(CategoryClick $categoryClick): static
    {
        if ($this->categoryClicks->removeElement($categoryClick)) {
            // set the owning side to null (unless already changed)
            if ($categoryClick->getNews() === $this) {
                $categoryClick->setNews(null);
            }
        }

        return $this;
    }
}
