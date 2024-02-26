<?php

namespace App\Entity;

use App\Repository\OrganizationRepository;
use Doctrine\DBAL\Types\Types;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Mapping as ORM;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: OrganizationRepository::class)]
class Organization
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $mnName = null;

    #[ORM\Column(length: 255)]
    private ?string $enName = null;

    // #[ORM\Column(length: 255, nullable: true)]
    // private ?string $imageUrl = null;

    // #[Vich\UploadableField(mapping: "app_image", fileNameProperty: "imageUrl")]
    // private ?File $imageFile = null;

    #[ORM\Column(length: 255)]
    private ?string $logo = null;

    #[Vich\UploadableField(mapping: "app_image", fileNameProperty: "logo")]
    private ?File $logoFile = null;

    // #[ORM\Column(type: Types::TEXT, nullable: true)]
    // private ?string $mnDescription = null;

    // #[ORM\Column(length: 255, nullable: true)]
    // private ?string $enDescription = null;

    // #[ORM\Column(type: Types::TEXT)]
    // private ?string $cnDescription = null;

    // #[ORM\Column(length: 255, nullable: true)]
    // private ?string $contact = null;

    // #[ORM\Column(length: 255, nullable: true)]
    // private ?string $webUrl = null;

    // #[ORM\Column(length: 255)]
    // private ?string $address = null;

    #[ORM\Column(length: 32)]
    private ?string $type = null;

    #[ORM\ManyToOne(inversedBy: 'organizations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CmsUser $createdUser = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?bool $active = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
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

    public function getEnName(): ?string
    {
        return $this->enName;
    }

    public function setEnName(string $enName): static
    {
        $this->enName = $enName;

        return $this;
    }

    // public function getImageUrl(): ?string
    // {
    //     return $this->imageUrl;
    // }

    // public function setImageUrl(?string $imageUrl): static
    // {
    //     $this->imageUrl = $imageUrl;

    //     return $this;
    // }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): static
    {
        $this->logo = $logo;

        return $this;
    }

    // public function getMnDescription(): ?string
    // {
    //     return $this->mnDescription;
    // }

    // public function setMnDescription(string $mnDescription): static
    // {
    //     $this->mnDescription = $mnDescription;

    //     return $this;
    // }

    // public function getEnDescription(): ?string
    // {
    //     return $this->enDescription;
    // }

    // public function setEnDescription(?string $enDescription): static
    // {
    //     $this->enDescription = $enDescription;

    //     return $this;
    // }

    // public function getCnDescription(): ?string
    // {
    //     return $this->cnDescription;
    // }

    // public function setCnDescription(string $cnDescription): static
    // {
    //     $this->cnDescription = $cnDescription;

    //     return $this;
    // }

    // public function getContact(): ?string
    // {
    //     return $this->contact;
    // }

    // public function setContact(?string $contact): static
    // {
    //     $this->contact = $contact;

    //     return $this;
    // }

    // public function getWebUrl(): ?string
    // {
    //     return $this->webUrl;
    // }

    // public function setWebUrl(?string $webUrl): static
    // {
    //     $this->webUrl = $webUrl;

    //     return $this;
    // }

    // public function getAddress(): ?string
    // {
    //     return $this->address;
    // }

    // public function setAddress(string $address): static
    // {
    //     $this->address = $address;

    //     return $this;
    // }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

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



    // public function setImageFile(File $image = null)
    // {
    //     $this->imageFile = $image;

    //     if ($image) {
    //         $this->updatedAt = new \DateTime('now');
    //     }
    // }

    // public function getImageFile()
    // {
    //     return $this->imageFile;
    // }

    public function setLogoFile(File $image = null)
    {
        $this->logoFile = $image;

        if ($image) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getLogoFile()
    {
        return $this->logoFile;
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

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): static
    {
        $this->active = $active;

        return $this;
    }
}
