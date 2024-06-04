<?php

namespace App\Entity;

use App\Repository\CompanyStructureRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: CompanyStructureRepository::class)]
class CompanyStructure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $mnName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $web = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mnAddress = null;

    #[Vich\UploadableField(mapping: "app_image", fileNameProperty: "icon")]
    #[Assert\File(
        maxSize: '3M',
    )]
    private ?File $iconFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $icon = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $updateAt = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $mnBody = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $enName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cnName = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $enBody = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $cnBody = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $enAddress = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cnAddress = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updateAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMnName(): ?string
    {
        return $this->mnName;
    }

    public function setMnName(string $mnName): static
    {
        $this->mnName = $mnName;

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

    public function getWeb(): ?string
    {
        return $this->web;
    }

    public function setWeb(?string $web): static
    {
        $this->web = $web;

        return $this;
    }

    public function getMnAddress(): ?string
    {
        return $this->mnAddress;
    }

    public function setMnAddress(?string $mnAddress): static
    {
        $this->mnAddress = $mnAddress;

        return $this;
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

    public function setIconFile(File $image = null)
    {
        $this->iconFile = $image;

        if ($image) {
            $this->updateAt = new \DateTime('now');
        }
    }

    public function getIconFile()
    {
        return $this->iconFile;
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

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeInterface $updateAt): static
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function getMnBody(): ?string
    {
        return $this->mnBody;
    }

    public function setMnBody(string $mnBody): static
    {
        $this->mnBody = $mnBody;

        return $this;
    }

    public function getEnName(): ?string
    {
        return $this->enName;
    }

    public function setEnName(?string $enName): static
    {
        $this->enName = $enName;

        return $this;
    }

    public function getCnName(): ?string
    {
        return $this->cnName;
    }

    public function setCnName(?string $cnName): static
    {
        $this->cnName = $cnName;

        return $this;
    }

    public function getEnBody(): ?string
    {
        return $this->enBody;
    }

    public function setEnBody(?string $enBody): static
    {
        $this->enBody = $enBody;

        return $this;
    }

    public function getCnBody(): ?string
    {
        return $this->cnBody;
    }

    public function setCnBody(?string $cnBody): static
    {
        $this->cnBody = $cnBody;

        return $this;
    }

    public function getEnAddress(): ?string
    {
        return $this->enAddress;
    }

    public function setEnAddress(?string $enAddress): static
    {
        $this->enAddress = $enAddress;

        return $this;
    }

    public function getCnAddress(): ?string
    {
        return $this->cnAddress;
    }

    public function setCnAddress(?string $cnAddress): static
    {
        $this->cnAddress = $cnAddress;

        return $this;
    }
}
