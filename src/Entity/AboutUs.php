<?php

namespace App\Entity;

use App\Repository\AboutUsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: AboutUsRepository::class)]
class AboutUs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageUrl = null;

    #[Vich\UploadableField(mapping: "app_image", fileNameProperty: "imageUrl")]
    #[Assert\File(
        maxSize: '3M',
    )]
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

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $mnDescription = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $enDescription = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $cnDescription = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $mnVision = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $enVision = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $cnVision = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $enValue = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $mnValue = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $cnValue = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $enStrategyPurpose = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $cnStrategyPurpose = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $mnStrategyPurpose = null;

    #[ORM\Column(nullable: true)]
    private ?int $thirdNumber = null;

    #[ORM\Column(nullable: true)]
    private ?int $fourthNumber = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMnDescription(): ?string
    {
        return $this->mnDescription;
    }

    public function setMnDescription(?string $mnDescription): static
    {
        $this->mnDescription = $mnDescription;

        return $this;
    }

    public function getEnDescription(): ?string
    {
        return $this->enDescription;
    }

    public function setEnDescription(?string $enDescription): static
    {
        $this->enDescription = $enDescription;

        return $this;
    }

    public function getCnDescription(): ?string
    {
        return $this->cnDescription;
    }

    public function setCnDescription(?string $cnDescription): static
    {
        $this->cnDescription = $cnDescription;

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

    public function getEnValue(): ?string
    {
        return $this->enValue;
    }

    public function setEnValue(string $enValue): static
    {
        $this->enValue = $enValue;

        return $this;
    }

    public function getMnValue(): ?string
    {
        return $this->mnValue;
    }

    public function setMnValue(?string $mnValue): static
    {
        $this->mnValue = $mnValue;

        return $this;
    }

    public function getCnValue(): ?string
    {
        return $this->cnValue;
    }

    public function setCnValue(?string $cnValue): static
    {
        $this->cnValue = $cnValue;

        return $this;
    }

    public function getEnStrategyPurpose(): ?string
    {
        return $this->enStrategyPurpose;
    }

    public function setEnStrategyPurpose(?string $enStrategyPurpose): static
    {
        $this->enStrategyPurpose = $enStrategyPurpose;

        return $this;
    }

    public function getCnStrategyPurpose(): ?string
    {
        return $this->cnStrategyPurpose;
    }

    public function setCnStrategyPurpose(?string $cnStrategyPurpose): static
    {
        $this->cnStrategyPurpose = $cnStrategyPurpose;

        return $this;
    }

    public function getMnStrategyPurpose(): ?string
    {
        return $this->mnStrategyPurpose;
    }

    public function setMnStrategyPurpose(?string $mnStrategyPurpose): static
    {
        $this->mnStrategyPurpose = $mnStrategyPurpose;

        return $this;
    }

    public function getThirdNumber(): ?int
    {
        return $this->thirdNumber;
    }

    public function setThirdNumber(?int $thirdNumber): static
    {
        $this->thirdNumber = $thirdNumber;

        return $this;
    }

    public function getFourthNumber(): ?int
    {
        return $this->fourthNumber;
    }

    public function setFourthNumber(?int $fourthNumber): static
    {
        $this->fourthNumber = $fourthNumber;

        return $this;
    }
}
