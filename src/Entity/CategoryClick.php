<?php

namespace App\Entity;

use App\Repository\CategoryClickRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryClickRepository::class)]
class CategoryClick
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'categoryClicks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?News $news = null;

    #[ORM\ManyToOne(inversedBy: 'categoryClicks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MainCategory $mainCategory = null;

    #[ORM\ManyToOne(inversedBy: 'categoryClicks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?SubCategory $subCategory = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNews(): ?News
    {
        return $this->news;
    }

    public function setNews(?News $news): static
    {
        $this->news = $news;

        return $this;
    }

    public function getMainCategory(): ?MainCategory
    {
        return $this->mainCategory;
    }

    public function setMainCategory(?MainCategory $mainCategory): static
    {
        $this->mainCategory = $mainCategory;

        return $this;
    }

    public function getSubCategory(): ?SubCategory
    {
        return $this->subCategory;
    }

    public function setSubCategory(?SubCategory $subCategory): static
    {
        $this->subCategory = $subCategory;

        return $this;
    }
}
