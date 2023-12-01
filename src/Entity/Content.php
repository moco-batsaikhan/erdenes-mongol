<?php

namespace App\Entity;

use App\Repository\ContentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\Column(type: Types::TEXT)]
    private ?string $body = null;

    #[ORM\Column]
    private ?int $priority = null;

    #[ORM\OneToMany(mappedBy: 'content', targetEntity: ContentConnection::class, orphanRemoval: true)]
    private Collection $contentConnections;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pdfFileName = null;

    public function __construct()
    {
        $this->contentConnections = new ArrayCollection();
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

    /**
     * @return Collection<int, ContentConnection>
     */
    public function getContentConnections(): Collection
    {
        return $this->contentConnections;
    }

    public function addContentConnection(ContentConnection $contentConnection): static
    {
        if (!$this->contentConnections->contains($contentConnection)) {
            $this->contentConnections->add($contentConnection);
            $contentConnection->setContent($this);
        }

        return $this;
    }

    public function removeContentConnection(ContentConnection $contentConnection): static
    {
        if ($this->contentConnections->removeElement($contentConnection)) {
            // set the owning side to null (unless already changed)
            if ($contentConnection->getContent() === $this) {
                $contentConnection->setContent(null);
            }
        }

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
}
