<?php

namespace App\Entity;

use App\Repository\AboutUsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: AboutUsRepository::class)]
class AboutUs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mnPurpose = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $enPurpose = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cnPurpose = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mnVision = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $enVision = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cnVision = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $enSlogan = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mnSlogan = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cnSlogan = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageUrl = null;

    #[Vich\UploadableField(mapping: "app_image", fileNameProperty: "imageUrl")]
    private ?File $imageFile = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $enPrinciples = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $mnPrinciples = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $cnPrinciples = null;

    #[ORM\Column(nullable: true)]
    private ?array $data = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column]
    private ?int $firsNumber = null;

    #[ORM\Column]
    private ?int $secondNumber = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMnPurpose(): ?string
    {
        return $this->mnPurpose;
    }

    public function setMnPurpose(?string $mnPurpose): static
    {
        $this->mnPurpose = $mnPurpose;

        return $this;
    }

    public function getEnPurpose(): ?string
    {
        return $this->enPurpose;
    }

    public function setEnPurpose(?string $enPurpose): static
    {
        $this->enPurpose = $enPurpose;

        return $this;
    }

    public function getCnPurpose(): ?string
    {
        return $this->cnPurpose;
    }

    public function setCnPurpose(?string $cnPurpose): static
    {
        $this->cnPurpose = $cnPurpose;

        return $this;
    }

    public function getMnVision(): ?string
    {
        return $this->mnVision;
    }

    public function setMnVision(?string $mnVision): static
    {
        $this->mnVision = $mnVision;

        return $this;
    }

    public function getEnVision(): ?string
    {
        return $this->enVision;
    }

    public function setEnVision(?string $enVision): static
    {
        $this->enVision = $enVision;

        return $this;
    }

    public function getCnVision(): ?string
    {
        return $this->cnVision;
    }

    public function setCnVision(?string $cnVision): static
    {
        $this->cnVision = $cnVision;

        return $this;
    }

    public function getEnSlogan(): ?string
    {
        return $this->enSlogan;
    }

    public function setEnSlogan(?string $enSlogan): static
    {
        $this->enSlogan = $enSlogan;

        return $this;
    }

    public function getMnSlogan(): ?string
    {
        return $this->mnSlogan;
    }

    public function setMnSlogan(?string $mnSlogan): static
    {
        $this->mnSlogan = $mnSlogan;

        return $this;
    }

    public function getCnSlogan(): ?string
    {
        return $this->cnSlogan;
    }

    public function setCnSlogan(?string $cnSlogan): static
    {
        $this->cnSlogan = $cnSlogan;

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

    public function getEnPrinciples(): ?string
    {
        return $this->enPrinciples;
    }

    public function setEnPrinciples(?string $enPrinciples): static
    {
        $this->enPrinciples = $enPrinciples;

        return $this;
    }

    public function getMnPrinciples(): ?string
    {
        return $this->mnPrinciples;
    }

    public function setMnPrinciples(?string $mnPrinciples): static
    {
        $this->mnPrinciples = $mnPrinciples;

        return $this;
    }

    public function getCnPrinciples(): ?string
    {
        return $this->cnPrinciples;
    }

    public function setCnPrinciples(?string $cnPrinciples): static
    {
        $this->cnPrinciples = $cnPrinciples;

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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

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

    public function getFirsNumber(): ?int
    {
        return $this->firsNumber;
    }

    public function setFirsNumber(int $firsNumber): static
    {
        $this->firsNumber = $firsNumber;

        return $this;
    }

    public function getSecondNumber(): ?int
    {
        return $this->secondNumber;
    }

    public function setSecondNumber(int $secondNumber): static
    {
        $this->secondNumber = $secondNumber;

        return $this;
    }
}
