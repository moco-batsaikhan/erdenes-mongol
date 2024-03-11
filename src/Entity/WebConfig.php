<?php

namespace App\Entity;

use App\Repository\WebConfigRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: WebConfigRepository::class)]
class WebConfig
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 32, nullable: true)]
    private ?string $colorCode = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $transparentImage = null;

    #[Vich\UploadableField(mapping: "app_image", fileNameProperty: "transparentImage")]
    #[Assert\File(
        maxSize: '3M',
    )]
    private ?File $transparentImageFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sloganImage = null;

    #[Vich\UploadableField(mapping: "app_image", fileNameProperty: "sloganImage")]
    #[Assert\File(
        maxSize: '3M',
    )]
    private ?File $sloganImageFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $coverImage = null;

    #[Vich\UploadableField(mapping: "app_image", fileNameProperty: "coverImage")]
    #[Assert\File(
        maxSize: '3M',
    )]
    private ?File $coverImageFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $backgroundColor = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    public function setTransparentImageFile(File $image = null)
    {
        $this->transparentImageFile = $image;

        if ($image) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getTransparentImageFile()
    {
        return $this->transparentImageFile;
    }

    public function setSloganImageFile(File $image = null)
    {
        $this->sloganImageFile = $image;

        if ($image) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getSloganImageFile()
    {
        return $this->sloganImageFile;
    }

    public function setCoverImageFile(File $image = null)
    {
        $this->coverImageFile = $image;

        if ($image) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getCoverImageFile()
    {
        return $this->coverImageFile;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getColorCode(): ?string
    {
        return $this->colorCode;
    }

    public function setColorCode(string $colorCode): static
    {
        $this->colorCode = $colorCode;

        return $this;
    }

    public function getTransparentImage(): ?string
    {
        return $this->transparentImage;
    }

    public function setTransparentImage(?string $transparentImage): static
    {
        $this->transparentImage = $transparentImage;

        return $this;
    }

    public function getSloganImage(): ?string
    {
        return $this->sloganImage;
    }

    public function setSloganImage(?string $sloganImage): static
    {
        $this->sloganImage = $sloganImage;

        return $this;
    }

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function setCoverImage(?string $coverImage): static
    {
        $this->coverImage = $coverImage;

        return $this;
    }

    public function getBackgroundColor(): ?string
    {
        return $this->backgroundColor;
    }

    public function setBackgroundColor(?string $backgroundColor): static
    {
        $this->backgroundColor = $backgroundColor;

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
}
