<?php

namespace App\Entity;

use App\Entity\Prop;
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
 *      "attribute",
 *      href = @Hateoas\Route(
 *          "devicePropAttr",
 *          parameters = { "id" = "expr(object.getId())" }
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups="getDevicesDetails")
 * )
 * 
 * @Hateoas\Relation(
 *      "attribute",
 *      href = @Hateoas\Route(
 *          "deviceAttr",
 *          parameters = { "id" = "expr(object.getId())" }
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups="getDevice")
 * )
 *
 * @Hateoas\Relation(
 *      "attribute",
 *      href = @Hateoas\Route(
 *          "devicePropAttr",
 *          parameters = { "id" = "expr(object.getId())" }
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups={"getProps"})
 * )
 *
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "devicePropAttr",
 *          parameters = { "id" = "expr(object.getId())" }
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups="getAttr")
 * )
 *
 */

#[ORM\Entity(repositoryClass: PropRepository::class)]
#[Broadcast]
class Attr
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['getDevicesDetails', 'getProps', 'getAttr'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['getDevicesDetails', 'getProps', 'getAttr'])]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: Prop::class, mappedBy: 'attr')]
    private Collection $props;

    public function __construct()
    {
        $this->props = new ArrayCollection();
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

    public function getProps(): Collection
    {
        return $this->props;
    }

    public function addProp(Prop $prop): static
    {
        if (!$this->props->contains($prop)) {
            $this->props->add($prop);
            $prop->setAttr($this);
        }
        return $this;
    }

    public function removeProp(Prop $prop): static
    {
        if ($this->props->removeElement($prop)) {
            // set the owning side to null (unless already changed)
            if ($prop->getAttr() === $this) {
                $prop->setAttr(null);
            }
        }
        return $this;
    }

}
