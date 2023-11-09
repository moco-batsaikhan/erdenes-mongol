<?php

namespace App\Entity;

use App\Repository\ContentConnectionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContentConnectionRepository::class)]
class ContentConnection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'contentConnections')]
    #[ORM\JoinColumn(nullable: false)]
    private ?News $news = null;

    #[ORM\ManyToOne(inversedBy: 'contentConnections')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Content $content = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNews(): ?News
    {
        return $this->news;
    }

    public function setNews(?News $news): static
    {
        $this->news = $news;

        return $this;
    }

    public function getContent(): ?Content
    {
        return $this->content;
    }

    public function setContent(?Content $content): static
    {
        $this->content = $content;

        return $this;
    }
}
