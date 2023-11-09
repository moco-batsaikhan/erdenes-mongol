<?php

namespace App\Entity;

use App\Repository\CmsUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CmsUserRepository::class)]
class CmsUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 16, nullable: true)]
    private ?string $username = null;

    #[ORM\Column(length: 32, nullable: true)]
    private ?string $password = null;

    #[ORM\Column(length: 32, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 16, nullable: true)]
    private ?string $firstname = null;

    #[ORM\Column(length: 16, nullable: true)]
    private ?string $lastname = null;

    #[ORM\Column(length: 16, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\OneToMany(mappedBy: 'createdUser', targetEntity: Banner::class)]
    private Collection $banners;

    #[ORM\OneToMany(mappedBy: 'createdUser', targetEntity: MainCategory::class, orphanRemoval: true)]
    private Collection $mainCategories;

    #[ORM\OneToMany(mappedBy: 'createdUser', targetEntity: SubCategory::class, orphanRemoval: true)]
    private Collection $subCategory;

    #[ORM\OneToMany(mappedBy: 'createdUser', targetEntity: Map::class, orphanRemoval: true)]
    private Collection $map;

    #[ORM\OneToMany(mappedBy: 'createdUser', targetEntity: Currency::class, orphanRemoval: true)]
    private Collection $currency;

    #[ORM\OneToMany(mappedBy: 'createdUser', targetEntity: PartnerOrganization::class, orphanRemoval: true)]
    private Collection $partnerOrganizations;

    #[ORM\OneToMany(mappedBy: 'createdUser', targetEntity: News::class, orphanRemoval: true)]
    private Collection $news;

    public function __construct()
    {
        $this->banners = new ArrayCollection();
        $this->mainCategories = new ArrayCollection();
        $this->subCategory = new ArrayCollection();
        $this->map = new ArrayCollection();
        $this->currency = new ArrayCollection();
        $this->partnerOrganizations = new ArrayCollection();
        $this->news = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

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

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return Collection<int, Banner>
     */
    public function getBanners(): Collection
    {
        return $this->banners;
    }

    public function addBanner(Banner $banner): static
    {
        if (!$this->banners->contains($banner)) {
            $this->banners->add($banner);
            $banner->setCreatedUser($this);
        }

        return $this;
    }

    public function removeBanner(Banner $banner): static
    {
        if ($this->banners->removeElement($banner)) {
            // set the owning side to null (unless already changed)
            if ($banner->getCreatedUser() === $this) {
                $banner->setCreatedUser(null);
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
            $mainCategory->setCreatedUser($this);
        }

        return $this;
    }

    public function removeMainCategory(MainCategory $mainCategory): static
    {
        if ($this->mainCategories->removeElement($mainCategory)) {
            // set the owning side to null (unless already changed)
            if ($mainCategory->getCreatedUser() === $this) {
                $mainCategory->setCreatedUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SubCategory>
     */
    public function getSubCategory(): Collection
    {
        return $this->subCategory;
    }

    public function addsubCategory(SubCategory $subCategory): static
    {
        if (!$this->subCategory->contains($subCategory)) {
            $this->subCategory->add($subCategory);
            $subCategory->setCreatedUser($this);
        }

        return $this;
    }

    public function removeSubCategory(SubCategory $subCategory): static
    {
        if ($this->subCategory->removeElement($subCategory)) {
            // set the owning side to null (unless already changed)
            if ($subCategory->getCreatedUser() === $this) {
                $subCategory->setCreatedUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Map>
     */
    public function getMap(): Collection
    {
        return $this->map;
    }

    public function addMap(Map $map): static
    {
        if (!$this->map->contains($map)) {
            $this->map->add($map);
            $map->setCreatedUser($this);
        }

        return $this;
    }

    public function removeMap(Map $map): static
    {
        if ($this->map->removeElement($map)) {
            // set the owning side to null (unless already changed)
            if ($map->getCreatedUser() === $this) {
                $map->setCreatedUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Currency>
     */
    public function getCurrency(): Collection
    {
        return $this->currency;
    }

    public function addCurrency(Currency $currency): static
    {
        if (!$this->currency->contains($currency)) {
            $this->currency->add($currency);
            $currency->setCreatedUser($this);
        }

        return $this;
    }

    public function removeCurrency(Currency $currency): static
    {
        if ($this->currency->removeElement($currency)) {
            // set the owning side to null (unless already changed)
            if ($currency->getCreatedUser() === $this) {
                $currency->setCreatedUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PartnerOrganization>
     */
    public function getPartnerOrganizations(): Collection
    {
        return $this->partnerOrganizations;
    }

    public function addPartnerOrganization(PartnerOrganization $partnerOrganization): static
    {
        if (!$this->partnerOrganizations->contains($partnerOrganization)) {
            $this->partnerOrganizations->add($partnerOrganization);
            $partnerOrganization->setCreatedUser($this);
        }

        return $this;
    }

    public function removePartnerOrganization(PartnerOrganization $partnerOrganization): static
    {
        if ($this->partnerOrganizations->removeElement($partnerOrganization)) {
            // set the owning side to null (unless already changed)
            if ($partnerOrganization->getCreatedUser() === $this) {
                $partnerOrganization->setCreatedUser(null);
            }
        }

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
            $news->setCreatedUser($this);
        }

        return $this;
    }

    public function removeNews(News $news): static
    {
        if ($this->news->removeElement($news)) {
            // set the owning side to null (unless already changed)
            if ($news->getCreatedUser() === $this) {
                $news->setCreatedUser(null);
            }
        }

        return $this;
    }
}
