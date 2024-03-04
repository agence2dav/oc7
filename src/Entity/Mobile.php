<?php

namespace App\Entity;

use App\Repository\MobileRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MobileRepository::class)]
class Mobile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $model = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $releaseDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dimensions = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $weight = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $box = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $battery = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $price = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $screenType = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $screenSize = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $screenZone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $resolution = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photoFront = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $video = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $os = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $chipset = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $gpu = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $memory = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sim = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $url = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(?\DateTimeInterface $releaseDate): static
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getDimensions(): ?string
    {
        return $this->dimensions;
    }

    public function setDimensions(?string $dimensions): static
    {
        $this->dimensions = $dimensions;

        return $this;
    }

    public function getWeight(): ?string
    {
        return $this->weight;
    }

    public function setWeight(?string $weight): static
    {
        $this->weight = $weight;

        return $this;
    }

    public function getBox(): ?string
    {
        return $this->box;
    }

    public function setBox(?string $box): static
    {
        $this->box = $box;

        return $this;
    }

    public function getBattery(): ?string
    {
        return $this->battery;
    }

    public function setBattery(?string $battery): static
    {
        $this->battery = $battery;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getScreenType(): ?string
    {
        return $this->screenType;
    }

    public function setScreenType(?string $screenType): static
    {
        $this->screenType = $screenType;

        return $this;
    }

    public function getScreenSize(): ?string
    {
        return $this->screenSize;
    }

    public function setScreenSize(?string $screenSize): static
    {
        $this->screenSize = $screenSize;

        return $this;
    }

    public function getScreenZone(): ?string
    {
        return $this->screenZone;
    }

    public function setScreenZone(?string $screenZone): static
    {
        $this->screenZone = $screenZone;

        return $this;
    }

    public function getResolution(): ?string
    {
        return $this->resolution;
    }

    public function setResolution(?string $resolution): static
    {
        $this->resolution = $resolution;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getPhotoFront(): ?string
    {
        return $this->photoFront;
    }

    public function setPhotoFront(?string $photoFront): static
    {
        $this->photoFront = $photoFront;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): static
    {
        $this->video = $video;

        return $this;
    }

    public function getOs(): ?string
    {
        return $this->os;
    }

    public function setOs(?string $os): static
    {
        $this->os = $os;

        return $this;
    }

    public function getChipset(): ?string
    {
        return $this->chipset;
    }

    public function setChipset(?string $chipset): static
    {
        $this->chipset = $chipset;

        return $this;
    }

    public function getGpu(): ?string
    {
        return $this->gpu;
    }

    public function setGpu(?string $gpu): static
    {
        $this->gpu = $gpu;

        return $this;
    }

    public function getMemory(): ?string
    {
        return $this->memory;
    }

    public function setMemory(?string $memory): static
    {
        $this->memory = $memory;

        return $this;
    }

    public function getSim(): ?string
    {
        return $this->sim;
    }

    public function setSim(?string $sim): static
    {
        $this->sim = $sim;

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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): static
    {
        $this->url = $url;

        return $this;
    }
}
