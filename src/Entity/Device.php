<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\DeviceRepository;
use Symfony\UX\Turbo\Attribute\Broadcast;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
//use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation\Groups;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "devicesList",
 *          parameters = { }
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups="getDevicesDetails")
 * )
 *
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "deviceDetails",
 *          parameters = { "id" = "expr(object.getId())" }
 *      ),
 * )
 *
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "deviceProps",
 *          parameters = { "id" = "expr(object.getDeviceProp()->getProp()->getId())" }
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups="getDevicesDetails")
 * )
 *
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "devicePropAttr",
 *          parameters = { "id" = "expr(object.getDeviceProp()->getProp()->getAttr()->Id())" }
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups="getDevicesDetails")
 * )
 *
 */

#[ORM\Entity(repositoryClass: DeviceRepository::class)]
#[Broadcast]
#[UniqueEntity(fields: ['name'], message: 'Ce modèle existe déjà')]
class Device
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['getDevicesSummary'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['getDevicesSummary'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['getDevicesDetails'])]
    private ?string $url = null;

    #[ORM\Column(length: 255)]
    #[Groups(['getDevicesDetails'])]
    private ?string $image = null;

    #[ORM\Column]
    #[Groups(['getDevicesDetails'])]
    private ?int $status = null;

    #[ORM\OneToMany(targetEntity: DeviceProp::class, mappedBy: 'device')]
    #[Groups(['getDevicesDetails'])]
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

    public function addDeviceProps(DeviceProp $deviceProps): static
    {
        if (!$this->deviceProps->contains($deviceProps)) {
            $this->deviceProps->add($deviceProps);
            $deviceProps->setDevice($this);
        }
        return $this;
    }

    public function removeDeviceProps(DeviceProp $deviceProps): static
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
