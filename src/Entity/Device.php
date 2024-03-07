<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\DeviceRepository;
use ApiPlatform\Metadata\ApiResource;
use Symfony\UX\Turbo\Attribute\Broadcast;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: DeviceRepository::class)]
#[Broadcast]
#[ApiResource]
#[UniqueEntity(fields: ['name'], message: 'Ce modèle existe déjà')]
class Device
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column]
    private ?int $status = null;

    #[ORM\OneToMany(targetEntity: DeviceProps::class, mappedBy: 'device')]
    private Collection $deviceProps;

    public function __construct()
    {
        $this->deviceProps = new ArrayCollection();
    }

    //get-set

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;
        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function getDeviceProps(): Collection
    {
        return $this->deviceProps;
    }

    public function addDeviceProps(DeviceProps $deviceProps): static
    {
        if (!$this->deviceProps->contains($deviceProps)) {
            $this->deviceProps->add($deviceProps);
            $deviceProps->setDevice($this);
        }
        return $this;
    }

    public function removeDeviceProps(DeviceProps $deviceProps): static
    {
        if ($this->deviceProps->removeElement($deviceProps)) {
            // set the owning side to null (unless already changed)
            if ($deviceProps->getDevice() === $this) {
                $deviceProps->setDevice(null);
            }
        }
        return $this;
    }

}
