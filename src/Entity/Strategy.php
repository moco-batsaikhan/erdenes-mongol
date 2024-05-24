<?php

namespace App\Entity;

use App\Repository\StrategyRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: StrategyRepository::class)]
class Strategy
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mnTitle = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $enTitle = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cnTitle = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $enVision = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $mnVision = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $cnVision = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $mnMission = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $enMission = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $cnMission = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $mnPurpose = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $cnPurpose = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $mnTarget = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $enTarget = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $cnTarget = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $enPurpose = null;

    #[ORM\Column(nullable: true)]
    private ?bool $active = null;

    #[Vich\UploadableField(mapping: "pdf_files", fileNameProperty: "pddFileName")]
    #[Assert\File(
        maxSize: '15M',
    )]
    private $pdfFile;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pddFileName = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEnTitle(): ?string
    {
        return $this->enTitle;
    }

    public function setEnTitle(?string $enTitle): static
    {
        $this->enTitle = $enTitle;

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

    public function getEnVision(): ?string
    {
        return $this->enVision;
    }

    public function setEnVision(?string $enVision): static
    {
        $this->enVision = $enVision;

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

    public function getCnVision(): ?string
    {
        return $this->cnVision;
    }

    public function setCnVision(?string $cnVision): static
    {
        $this->cnVision = $cnVision;

        return $this;
    }

    public function getMnMission(): ?string
    {
        return $this->mnMission;
    }

    public function setMnMission(?string $mnMission): static
    {
        $this->mnMission = $mnMission;

        return $this;
    }

    public function getEnMission(): ?string
    {
        return $this->enMission;
    }

    public function setEnMission(?string $enMission): static
    {
        $this->enMission = $enMission;

        return $this;
    }

    public function getCnMission(): ?string
    {
        return $this->cnMission;
    }

    public function setCnMission(?string $cnMission): static
    {
        $this->cnMission = $cnMission;

        return $this;
    }

    public function getMnPurpose(): ?string
    {
        return $this->mnPurpose;
    }

    public function setMnPurpose(string $mnPurpose): static
    {
        $this->mnPurpose = $mnPurpose;

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

    public function getMnTarget(): ?string
    {
        return $this->mnTarget;
    }

    public function setMnTarget(?string $mnTarget): static
    {
        $this->mnTarget = $mnTarget;

        return $this;
    }

    public function getEnTarget(): ?string
    {
        return $this->enTarget;
    }

    public function setEnTarget(?string $enTarget): static
    {
        $this->enTarget = $enTarget;

        return $this;
    }

    public function getCnTarget(): ?string
    {
        return $this->cnTarget;
    }

    public function setCnTarget(?string $cnTarget): static
    {
        $this->cnTarget = $cnTarget;

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

    public function getEnPurpose(): ?string
    {
        return $this->enPurpose;
    }

    public function setEnPurpose(?string $enPurpose): static
    {
        $this->enPurpose = $enPurpose;

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

    public function getPddFileName(): ?string
    {
        return $this->pddFileName;
    }

    public function setPddFileName(?string $pddFileName): static
    {
        $this->pddFileName = $pddFileName;

        return $this;
    }

    public function getPdfFile(): ?File
    {
        return $this->pdfFile;
    }

    public function setPdfFile(?File $pdfFile): void
    {
        $this->pdfFile = $pdfFile;
    }
}
