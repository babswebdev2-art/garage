<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\HasLifecycleCallbacks]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    #[ORM\Column(length: 255)]
    private ?string $introduction = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Ad::class, orphanRemoval: true)]
    private Collection $ads;

    public function __construct()
    {
        $this->ads = new ArrayCollection();
    }

    /**
     * Permet d'initialiser le slug automatiquement
     */
    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function initializeSlug(): void
    {
        if (empty($this->slug)) {
            $slugger = new AsciiSlugger();
            $this->slug = strtolower($slugger->slug($this->firstName . ' ' . $this->lastName));
        }
    }

    public function getFullName(): string
    {
        return "{$this->firstName} {$this->lastName}";
    }


    public function getId(): ?int
    { 
        return $this->id; 
    }

    public function getEmail(): ?string 
    { 
        return $this->email; 
    }
    public function setEmail(string $email): self 
    { 
        $this->email = $email; 
        return $this; 
    }

    public function getUserIdentifier(): string 
    { 
        return (string) $this->email; 
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }
    public function setRoles(array $roles): self 
    { 
        $this->roles = $roles; 
        return $this; 
    }

    public function getPassword(): string 
    { 
        return $this->password; 
    }
    public function setPassword(string $password): self 
    { 
        $this->password = $password; 
        return $this; 
    }

    public function getFirstName(): ?string 
    { 
        return $this->firstName; 
    }
    public function setFirstName(string $firstName): self 
    { 
        $this->firstName = $firstName; 
        return $this; 
    }

    public function getLastName(): ?string 
    { 
        return $this->lastName; 
    }
    public function setLastName(string $lastName): self 
    { 
        $this->lastName = $lastName; 
        return $this; 
    }

    public function getPicture(): ?string 
    { 
        return $this->picture;
    }
    public function setPicture(?string $picture): self 
    { 
        $this->picture = $picture; 
        return $this; 
    }

    public function getIntroduction(): ?string 
    { 
        return $this->introduction; 
    }
    public function setIntroduction(string $introduction): self 
    { 
        $this->introduction = $introduction; 
        return $this;
    }

    public function getDescription(): ?string 
    { 
        return $this->description; 
    }
    public function setDescription(string $description): self 
    {
        $this->description = $description;
        return $this; 
    }

    public function getSlug(): ?string 
    { 
        return $this->slug;
    }
    public function setSlug(string $slug): self 
    { 
        $this->slug = $slug; 
        return $this; 
    }

    public function getAds(): Collection 
    { 
        return $this->ads; 
    }

    public function eraseCredentials(): void {}
}
