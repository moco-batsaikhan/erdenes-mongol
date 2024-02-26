<?php

namespace App\Entity;

use App\Repository\NewsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

#[Vich\Uploadable]
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

    #[Vich\UploadableField(mapping: "app_image", fileNameProperty: "imageUrl")]
    private ?File $imageFile = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $mnHeadline = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $enHeadline = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $cnHeadline = null;

    #[ORM\ManyToOne(inversedBy: 'news')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CmsUser $createdUser = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\OneToMany(mappedBy: 'News', targetEntity: Content::class)]
    private Collection $contents;

    #[ORM\Column(length: 255)]
    private ?string $redirectType = null;

    #[ORM\Column(length: 16)]
    private ?string $processType = "CREATED";

    #[ORM\ManyToOne(inversedBy: 'news')]
    #[ORM\JoinColumn(nullable: false)]
    private ?NewsType $newsType = null;

    #[ORM\OneToMany(mappedBy: 'newsId', targetEntity: MainCategory::class)]
    private Collection $mainCategories;

    #[ORM\OneToMany(mappedBy: 'newsId', targetEntity: SubCategory::class)]
    private Collection $subCategories;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $bodyImageUrl = null;

    #[Vich\UploadableField(mapping: "app_image", fileNameProperty: "imageUrl")]
    private ?File $bodyimageFile = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->contents = new ArrayCollection();
        $this->mainCategories = new ArrayCollection();
        $this->subCategories = new ArrayCollection();
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

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
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

    /**
     * @return Collection<int, Content>
     */
    public function getContents(): Collection
    {
        return $this->contents;
    }

    public function addContent(Content $content): static
    {
        if (!$this->contents->contains($content)) {
            $this->contents->add($content);
            $content->setNews($this);
        }

        return $this;
    }

    public function removeContent(Content $content): static
    {
        if ($this->contents->removeElement($content)) {
            // set the owning side to null (unless already changed)
            if ($content->getNews() === $this) {
                $content->setNews(null);
            }
        }

        return $this;
    }

    public function getRedirectType(): ?string
    {
        return $this->redirectType;
    }

    public function setRedirectType(string $redirectType): static
    {
        $this->redirectType = $redirectType;

        return $this;
    }

    public function getProcessType(): ?string
    {
        return $this->processType;
    }

    public function setProcessType(string $processType): static
    {
        $this->processType = $processType;

        return $this;
    }

    public function getNewsType(): ?NewsType
    {
        return $this->newsType;
    }

    public function setNewsType(?NewsType $newsType): static
    {
        $this->newsType = $newsType;

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
            $mainCategory->setNewsId($this);
        }

        return $this;
    }

    public function removeMainCategory(MainCategory $mainCategory): static
    {
        if ($this->mainCategories->removeElement($mainCategory)) {
            // set the owning side to null (unless already changed)
            if ($mainCategory->getNewsId() === $this) {
                $mainCategory->setNewsId(null);
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
            $subCategory->setNewsId($this);
        }

        return $this;
    }

    public function removeSubCategory(SubCategory $subCategory): static
    {
        if ($this->subCategories->removeElement($subCategory)) {
            // set the owning side to null (unless already changed)
            if ($subCategory->getNewsId() === $this) {
                $subCategory->setNewsId(null);
            }
        }

        return $this;
    }

    public function getBodyImageUrl(): ?string
    {
        return $this->bodyImageUrl;
    }

    public function setBodyImageUrl(?string $bodyImageUrl): static
    {
        $this->bodyImageUrl = $bodyImageUrl;

        return $this;
    }

    public function setBodyImageFile(File $image = null)
    {
        $this->bodyimageFile = $image;

        if ($image) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getBodyImageFile()
    {
        return $this->bodyimageFile;
    }
}
