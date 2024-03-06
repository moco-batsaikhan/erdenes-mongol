<?php

namespace App\Entity;

use App\Repository\BannerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: BannerRepository::class)]
class Banner
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $icon = null;

    #[Vich\UploadableField(mapping: "app_image", fileNameProperty: "icon")]
    private ?File $iconFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cn_text = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mn_text = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $en_text = null;

    #[ORM\Column(nullable: true)]
    private ?bool $active = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageUrl = null;

    #[Vich\UploadableField(mapping: "app_image", fileNameProperty: "imageUrl")]
    private ?File $imageFile = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'banners')]
    private ?CmsUser $createdUser = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $enIcon = null;

    #[Vich\UploadableField(mapping: "app_image", fileNameProperty: "enIcon")]
    private ?File $enIconFile = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(?string $image_url): static
    {
        $this->imageUrl = $image_url;

        return $this;
    }

    public function getCnText(): ?string
    {
        return $this->cn_text;
    }

    public function setCnText(?string $cn_text): static
    {
        $this->cn_text = $cn_text;

        return $this;
    }

    public function getMnText(): ?string
    {
        return $this->mn_text;
    }

    public function setMnText(?string $mn_text): static
    {
        $this->mn_text = $mn_text;

        return $this;
    }

    public function getEnText(): ?string
    {
        return $this->en_text;
    }

    public function setEnText(?string $en_text): static
    {
        $this->en_text = $en_text;

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

    public function setIconFile(File $image = null)
    {
        $this->iconFile = $image;

        if ($image) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getIconFile()
    {
        return $this->iconFile;
    }

    public function setEnIconFile(File $image = null)
    {
        $this->enIconFile = $image;

        if ($image) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getEnIconFile()
    {
        return $this->enIconFile;
    }



    public function getEnIcon(): ?string
    {
        return $this->enIcon;
    }

    public function setEnIcon(?string $enIcon): static
    {
        $this->enIcon = $enIcon;

        return $this;
    }
}
