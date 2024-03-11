<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mnAddress = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $enAddress = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cnAddress = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

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
}
