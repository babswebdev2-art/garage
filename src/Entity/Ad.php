<?php

namespace App\Entity;

use App\Repository\AdRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[ORM\Entity(repositoryClass: AdRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Ad
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(length: 255)]
    private ?string $brand = null;

    #[ORM\Column(length: 255)]
    private ?string $model = null;

    #[ORM\Column(length: 255)]
    private ?string $coverImage = null;

    #[ORM\Column]
    private ?int $kilometers = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column]
    private ?int $owners = null;

    #[ORM\Column(length: 100)]
    private ?string $displacement = null;

    #[ORM\Column]
    private ?int $power = null;

    #[ORM\Column(length: 100)]
    private ?string $fuel = null;

    #[ORM\Column]
    private ?int $year = null;

    #[ORM\Column(length: 100)]
    private ?string $transmission = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $options = null;

    #[ORM\ManyToOne(inversedBy: 'ads')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;

    #[ORM\OneToMany(mappedBy: 'ad', targetEntity: Image::class, orphanRemoval: true)]
    private Collection $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function initializeSlug(): void
    {
        if (empty($this->slug)) {
            $slugger = new AsciiSlugger();
            $this->slug = strtolower($slugger->slug($this->title));
        }
    }

    public function getId(): ?int
     {
         return $this->id; 
    }
    public function getTitle(): ?string
    {
         return $this->title; 
    }
    public function setTitle(string $title): self 
    {
         $this->title = $title; 
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
    public function getBrand(): ?string 
    { 
        return $this->brand; 
    }
    public function setBrand(string $brand): self 
    { 
        $this->brand = $brand; 
        return $this; 
    }
    public function getModel(): ?string 
    { 
        return $this->model; 
    }
    public function setModel(string $model): self 
    { 
        $this->model = $model; return $this; 
    }
    public function getCoverImage(): ?string 
    { 
        return $this->coverImage; 
    }
    public function setCoverImage(string $coverImage): self 
    { 
        $this->coverImage = $coverImage;
         return $this; 
    }
    public function getKilometers(): ?int 
    { 
        return $this->kilometers; 
    }
    public function setKilometers(int $kilometers): self 
    { 
        $this->kilometers = $kilometers; 
        return $this; 
    }
    public function getPrice(): ?float 
    { 
        return $this->price;
   }
    public function setPrice(float $price): self 
    { 
        $this->price = $price; 
        return $this; 
    }
    public function getOwners(): ?int 
    { 
        return $this->owners; 
    }
    public function setOwners(int $owners): self 
    { 
        $this->owners = $owners; 
        return $this; 
    }
    public function getDisplacement(): ?string 
    { 
        return $this->displacement; 
    }
    public function setDisplacement(string $displacement): self 
    { 
        $this->displacement = $displacement; 
        return $this; 
    }
    public function getPower(): ?int 
    { 
        return $this->power; 
    }
    public function setPower(int $power): self 
    { 
        $this->power = $power; 
        return $this; 
    }
    public function getFuel(): ?string 
    { 
        return $this->fuel; 
    }
    public function setFuel(string $fuel): self 
    { 
        $this->fuel = $fuel; 
        return $this;
     }
    public function getYear(): ?int 
    {
         return $this->year; 
    }
    public function setYear(int $year): self 
    { 
        $this->year = $year; 
        return $this; 
    }
    public function getTransmission(): ?string 
    { 
        return $this->transmission; 
    }
    public function setTransmission(string $transmission): self 
    {
         $this->transmission = $transmission; 
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
    public function getOptions(): ?string 
    { 
        return $this->options; 
    }
    public function setOptions(?string $options): self 
    { 
        $this->options = $options; 
        return $this; 
    }
    public function getAuthor(): ?User 
    { 
        return $this->author;
     }
    public function setAuthor(?User $author): self 
    { 
        $this->author = $author; 
        return $this;
     }
    public function getImages(): Collection 
    { 
        return $this->images; 
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setAd($this);
        }
        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            if ($image->getAd() === $this) { $image->setAd(null); }
        }
        return $this;
    }
}
