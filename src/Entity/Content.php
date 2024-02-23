<?php

namespace App\Entity;

use App\Repository\ContentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;



#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: ContentRepository::class)]
class Content
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[Vich\UploadableField(mapping: "pdf_files", fileNameProperty: "pdfFileName")]
    private $pdfFile;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $body = null;

    #[ORM\Column]
    private ?int $priority = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pdfFileName = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\ManyToOne(inversedBy: 'contents')]
    private ?News $News = null;

    #[ORM\Column(nullable: true)]
    private ?array $file = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageFileName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $graphType = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mn_description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $en_description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cn_description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

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


    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): static
    {
        $this->body = $body;

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

    public function getPdfFileName(): ?string
    {
        return $this->pdfFileName;
    }

    public function setPdfFileName(?string $pdfFileName): static
    {
        $this->pdfFileName = $pdfFileName;

        return $this;
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

    public function getNews(): ?News
    {
        return $this->News;
    }

    public function setNews(?News $News): static
    {
        $this->News = $News;

        return $this;
    }

    public function getFile(): ?array
    {
        return $this->file;
    }

    public function setFile(?array $file): static
    {
        $this->file = $file;

        return $this;
    }

    public function getImageFileName(): ?string
    {
        return $this->imageFileName;
    }

    public function setImageFileName(?string $imageFileName): static
    {
        $this->imageFileName = $imageFileName;

        return $this;
    }

    public function getGraphType(): ?string
    {
        return $this->graphType;
    }

    public function setGraphType(?string $graphType): static
    {
        $this->graphType = $graphType;

        return $this;
    }

    public function getMnDescription(): ?string
    {
        return $this->mn_description;
    }

    public function setMnDescription(?string $mn_description): static
    {
        $this->mn_description = $mn_description;

        return $this;
    }

    public function getEnDescription(): ?string
    {
        return $this->en_description;
    }

    public function setEnDescription(?string $en_description): static
    {
        $this->en_description = $en_description;

        return $this;
    }

    public function getCnDescription(): ?string
    {
        return $this->cn_description;
    }

    public function setCnDescription(?string $cn_description): static
    {
        $this->cn_description = $cn_description;

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
}
