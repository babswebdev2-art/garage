<?php

namespace App\Entity;

use App\Repository\AdRepository;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AdRepository::class)]
#[ORM\HasLifecycleCallbacks()] //Automatiser du slug
class Ad
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le titre est obligatoire")]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $slug = null;

    #[ORM\Column(length: 255)]
    private ?string $model = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    #[Assert\Positive(message: "Le prix doit être un nombre positif")]
    private ?int $price = null;

    #[ORM\Column]
    private ?int $km = null;

    #[ORM\Column(length: 255)]
    private ?string $coverImage = null;

    #[ORM\Column]
    private ?int $annee = null;

    #[ORM\Column]
    private ?int $nbProprietaires = null;

    #[ORM\Column(length: 255)]
    private ?string $cylindree = null;

    #[ORM\Column]
    private ?int $puissance = null;

    #[ORM\Column(length: 255)]
    private ?string $carburant = null;

    #[ORM\Column(length: 255)]
    private ?string $transmission = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $options = null;

    #[ORM\ManyToOne(targetEntity: Brand::class, inversedBy: 'ads')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Brand $brand = null;

    // Relation vers l'Auteur (L'Admin qui crée l'annonce)
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'ads')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;

    /**
     * @var Collection<int, Image>
     */
    #[ORM\OneToMany(targetEntity: Image::class, mappedBy: 'ad', orphanRemoval: true)]
    private Collection $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    /**
     * Permet d'initialiser le slug automatiquement avant la création ou modification
     */
    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function initializeSlug(): void
    {
        if (empty($this->slug)) {
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->title);
        }
    }

    // --- GETTERS & SETTERS ---

    public function getId(): ?int

    {
        return $this->id;
    }

    public function getTitle(): ?string

    {
        return $this->title;
    }
    public function setTitle(string $title): static

    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string

    {
        return $this->slug;
    }
    public function setSlug(string $slug): static

    {
        $this->slug = $slug;

        return $this;
    }

    public function getModel(): ?string

    {
        return $this->model;
    }
    public function setModel(string $model): static

    {
        $this->model = $model; return $this;
    }

    public function getDescription(): ?string

    {
        return $this->description;
    }
    public function setDescription(string $description): static

    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?int

    {
        return $this->price;
    }
    public function setPrice(int $price): static

    {
        $this->price = $price;

        return $this;
    }

    public function getKm(): ?int

    {
        return $this->km;
    }
    public function setKm(int $km): static

    {
        $this->km = $km;

        return $this;
    }

    public function getCoverImage(): ?string

    {
        return $this->coverImage;
    }
    public function setCoverImage(string $coverImage): static

    {
        $this->coverImage = $coverImage;

        return $this;
    }

    public function getAnnee(): ?int

    {
        return $this->annee;
    }
    public function setAnnee(int $annee): static

    {
        $this->annee = $annee;

        return $this;
    }

    public function getNbProprietaires(): ?int

    {
        return $this->nbProprietaires;
    }
    public function setNbProprietaires(int $nbProprietaires): static

    {
        $this->nbProprietaires = $nbProprietaires;

        return $this;
    }

    public function getCylindree(): ?string

    {
        return $this->cylindree;
    }
    public function setCylindree(string $cylindree): static

    {
        $this->cylindree = $cylindree;

        return $this;
    }

    public function getPuissance(): ?int

    {
        return $this->puissance;
    }
    public function setPuissance(int $puissance): static

    {
        $this->puissance = $puissance;

        return $this;
    }

    public function getCarburant(): ?string

    {
        return $this->carburant;
    }
    public function setCarburant(string $carburant): static

    {
        $this->carburant = $carburant;

        return $this;
    }

    public function getTransmission(): ?string

    {
        return $this->transmission;
    }
    public function setTransmission(string $transmission): static

    {
        $this->transmission = $transmission;

        return $this;
    }

    public function getOptions(): ?string

    {
        return $this->options;
    }
    public function setOptions(string $options): static

    {
        $this->options = $options;

        return $this;
    }

    public function getBrand(): ?Brand

    {
        return $this->brand;
    }
    public function setBrand(?Brand $brand): static

    {
        $this->brand = $brand;

        return $this;
    }

    public function getAuthor(): ?User

    {
        return $this->author;
    }
    public function setAuthor(?User $author): static

    {
        $this->author = $author;

        return $this;
    }

    /** @return Collection<int, Image> */
    public function getImages(): Collection

    {
        return $this->images;
    }

    public function addImage(Image $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setAd($this);
        }
        return $this;
    }

    public function removeImage(Image $image): static
    {
        if ($this->images->removeElement($image)) {
            if ($image->getAd() === $this) {
                $image->setAd(null);
            }
        }
        return $this;
    }
}
