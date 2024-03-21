<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
class Employee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 32)]
    private ?string $mnName = null;

    #[ORM\Column(length: 32)]
    private ?string $enName = null;

    #[ORM\Column(length: 32)]
    private ?string $cnName = null;

    #[ORM\Column(length: 255)]
    private ?string $mnDivision = null;

    #[ORM\Column(length: 255)]
    private ?string $enDivision = null;

    #[ORM\Column(length: 255)]
    private ?string $cnDivision = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[Vich\UploadableField(mapping: "app_image", fileNameProperty: "image")]
    #[Assert\File(
        maxSize: '3M',
    )]
    private ?File $imageFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $department = null;

    #[ORM\Column]
    private ?int $priority = null;

    #[ORM\ManyToOne(inversedBy: 'Employee')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CmsUser $createdUser = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $updateAt = null;

    #[ORM\Column(nullable: true)]
    private ?bool $type = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $mnExperience = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $enExperience = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $cnExperience = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $facebook = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $twitter = null;

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

    public function getEnName(): ?string
    {
        return $this->enName;
    }

    public function setEnName(string $enName): static
    {
        $this->enName = $enName;

        return $this;
    }

    public function getCnName(): ?string
    {
        return $this->cnName;
    }

    public function setCnName(string $cnName): static
    {
        $this->cnName = $cnName;

        return $this;
    }

    public function getMnDivision(): ?string
    {
        return $this->mnDivision;
    }

    public function setMnDivision(string $mnDivision): static
    {
        $this->mnDivision = $mnDivision;

        return $this;
    }
    public function getEnDivision(): ?string
    {
        return $this->enDivision;
    }

    public function setEnDivision(string $enDivision): static
    {
        $this->enDivision = $enDivision;

        return $this;
    }
    public function getCnDivision(): ?string
    {
        return $this->cnDivision;
    }

    public function setCnDivision(string $cnDivision): static
    {
        $this->cnDivision = $cnDivision;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getDepartment(): ?string
    {
        return $this->department;
    }

    public function setDepartment(?string $department): static
    {
        $this->department = $department;

        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): static
    {
        $this->priority = $priority;

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
            $this->updateAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
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

    public function isType(): ?bool
    {
        return $this->type;
    }

    public function setType(?bool $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getMnExperience(): ?string
    {
        return $this->mnExperience;
    }

    public function setMnExperience(?string $mnExperience): static
    {
        $this->mnExperience = $mnExperience;

        return $this;
    }

    public function getEnExperience(): ?string
    {
        return $this->enExperience;
    }

    public function setEnExperience(?string $enExperience): static
    {
        $this->enExperience = $enExperience;

        return $this;
    }
    public function getCnExperience(): ?string
    {
        return $this->cnExperience;
    }

    public function setCnExperience(?string $cnExperience): static
    {
        $this->cnExperience = $cnExperience;

        return $this;
    }
    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(?string $facebook): static
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    public function setTwitter(?string $twitter): static
    {
        $this->twitter = $twitter;

        return $this;
    }
}
