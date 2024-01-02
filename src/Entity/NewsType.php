<?php

namespace App\Entity;

use App\Repository\NewsTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NewsTypeRepository::class)]
class NewsType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 32)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'newsType', targetEntity: News::class)]
    private Collection $news;

    #[ORM\OneToMany(mappedBy: 'newsTypeId', targetEntity: SubCategory::class)]
    private Collection $subCategories;

    #[ORM\OneToMany(mappedBy: 'newsTypeId', targetEntity: MainCategory::class)]
    private Collection $mainCategories;

    public function __construct()
    {
        $this->news = new ArrayCollection();
        $this->subCategories = new ArrayCollection();
        $this->mainCategories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, News>
     */
    public function getNews(): Collection
    {
        return $this->news;
    }

    public function addNews(News $news): static
    {
        if (!$this->news->contains($news)) {
            $this->news->add($news);
            $news->setNewsType($this);
        }

        return $this;
    }

    public function removeNews(News $news): static
    {
        if ($this->news->removeElement($news)) {
            // set the owning side to null (unless already changed)
            if ($news->getNewsType() === $this) {
                $news->setNewsType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SubCategory>
     */
    public function getSubCategories(): Collection
    {
        return $this->subCategories;
    }

    public function addSubCategory(SubCategory $subCategory): static
    {
        if (!$this->subCategories->contains($subCategory)) {
            $this->subCategories->add($subCategory);
            $subCategory->setNewsTypeId($this);
        }

        return $this;
    }

    public function removeSubCategory(SubCategory $subCategory): static
    {
        if ($this->subCategories->removeElement($subCategory)) {
            // set the owning side to null (unless already changed)
            if ($subCategory->getNewsTypeId() === $this) {
                $subCategory->setNewsTypeId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MainCategory>
     */
    public function getMainCategories(): Collection
    {
        return $this->mainCategories;
    }

    public function addMainCategory(MainCategory $mainCategory): static
    {
        if (!$this->mainCategories->contains($mainCategory)) {
            $this->mainCategories->add($mainCategory);
            $mainCategory->setNewsTypeId($this);
        }

        return $this;
    }

    public function removeMainCategory(MainCategory $mainCategory): static
    {
        if ($this->mainCategories->removeElement($mainCategory)) {
            // set the owning side to null (unless already changed)
            if ($mainCategory->getNewsTypeId() === $this) {
                $mainCategory->setNewsTypeId(null);
            }
        }

        return $this;
    }
}
