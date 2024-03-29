<?php

namespace App\Entity;

use App\Entity\Attr;
use App\Entity\DeviceProp;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PropRepository;
use JMS\Serializer\Annotation\Groups;
use Symfony\UX\Turbo\Attribute\Broadcast;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Hateoas\Configuration\Annotation as Hateoas;

//use Symfony\Component\Serializer\Annotation\Groups;

/**
 *
 * @Hateoas\Relation(
 *      "properties",
 *      href = @Hateoas\Route(
 *          "deviceProps",
 *          parameters = { "id" = "expr(object.getId())" }
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups="getDevicesDetails")
 * )
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "deviceProps",
 *          parameters = { "id" = "expr(object.getId())" }
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups="getProps")
 * )
 * 
 */

#[ORM\Entity(repositoryClass: PropRepository::class)]
#[Broadcast]
class Prop
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['getDevicesDetails', 'getProps', 'getAttr'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['getDevicesDetails', 'getProps'])]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'props')]
    #[Groups(['getDevicesDetails', 'getProps'])]
    private ?Attr $attr = null;

    #[ORM\OneToMany(targetEntity: DeviceProp::class, mappedBy: 'prop')]
    #[Groups(['getDevicesProps'])]
    private Collection $deviceProps;

    public function __construct()
    {
        $this->deviceProps = new ArrayCollection();
    }

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

    public function getAttr(): ?Attr
    {
        return $this->attr;
    }

    public function setAttr(?Attr $attr): static
    {
        $this->attr = $attr;
        return $this;
    }

    public function getDeviceProps(): Collection
    {
        return $this->deviceProps;
    }

    public function addDeviceProp(DeviceProp $deviceProp): static
    {
        if (!$this->deviceProps->contains($deviceProp)) {
            $this->deviceProps->add($deviceProp);
            $deviceProp->setProp($this);
        }
        return $this;
    }

    public function removeDeviceProp(DeviceProp $deviceProp): static
    {
        if ($this->deviceProps->removeElement($deviceProp)) {
            // set the owning side to null (unless already changed)
            if ($deviceProp->getProp() === $this) {
                $deviceProp->setProp(null);
            }
        }
        return $this;
    }
}
