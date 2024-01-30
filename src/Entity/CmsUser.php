<?php

namespace App\Entity;

use App\Repository\CmsUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: CmsUserRepository::class)]
class CmsUser implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;


    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\OneToMany(mappedBy: 'createdUser', targetEntity: DevelopmentHistory::class)]
    private Collection $developmentHistory;

    #[ORM\OneToMany(mappedBy: 'createdUser', targetEntity: Employee::class)]
    private Collection $Employee;

    #[ORM\OneToMany(mappedBy: 'createdUser', targetEntity: Organization::class)]
    private Collection $organizations;

    public function __construct()
    {
        $this->developmentHistory = new ArrayCollection();
        $this->Employee = new ArrayCollection();
        $this->organizations = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return bool
     */
    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    /**
     * @param bool $isVerified
     */
    public function setIsVerified(bool $isVerified): void
    {
        $this->isVerified = $isVerified;
    }

    /**
     * @return Collection<int, DevelopmentHistory>
     */
    public function getDevelopmentHistory(): Collection
    {
        return $this->developmentHistory;
    }

    public function addDevelopmentHistory(DevelopmentHistory $developmentHistory): static
    {
        if (!$this->developmentHistory->contains($developmentHistory)) {
            $this->developmentHistory->add($developmentHistory);
            $developmentHistory->setCreatedUser($this);
        }

        return $this;
    }

    public function removeDevelopmentHistory(DevelopmentHistory $developmentHistory): static
    {
        if ($this->developmentHistory->removeElement($developmentHistory)) {
            // set the owning side to null (unless already changed)
            if ($developmentHistory->getCreatedUser() === $this) {
                $developmentHistory->setCreatedUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Employee>
     */
    public function getEmployee(): Collection
    {
        return $this->Employee;
    }

    public function addEmployee(Employee $employee): static
    {
        if (!$this->Employee->contains($employee)) {
            $this->Employee->add($employee);
            $employee->setCreatedUser($this);
        }

        return $this;
    }

    public function removeEmployee(Employee $employee): static
    {
        if ($this->Employee->removeElement($employee)) {
            // set the owning side to null (unless already changed)
            if ($employee->getCreatedUser() === $this) {
                $employee->setCreatedUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Organization>
     */
    public function getOrganizations(): Collection
    {
        return $this->organizations;
    }

    public function addOrganization(Organization $organization): static
    {
        if (!$this->organizations->contains($organization)) {
            $this->organizations->add($organization);
            $organization->setCreatedUser($this);
        }

        return $this;
    }

    public function removeOrganization(Organization $organization): static
    {
        if ($this->organizations->removeElement($organization)) {
            // set the owning side to null (unless already changed)
            if ($organization->getCreatedUser() === $this) {
                $organization->setCreatedUser(null);
            }
        }

        return $this;
    }
}
