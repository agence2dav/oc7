<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use JMS\Serializer\Annotation\Since;
use JMS\Serializer\Annotation\Groups;
use Symfony\UX\Turbo\Attribute\Broadcast;
use Hateoas\Configuration\Annotation as Hateoas;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * 
 * @Hateoas\Relation(
 *      "clientDetails",
 *      href = @Hateoas\Route(
 *          "clientDetails",
 *          absolute = true,
 *          parameters = { "id" = "expr(object.getClient().getId())" }
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups="getUserSummary")
 * )
 * 
 * @Hateoas\Relation(
 *      "userDetails",
 *      href = @Hateoas\Route(
 *          "userDetails",
 *          absolute = true,
 *          parameters = { "clientId" = "expr(object.getClient().getId())", "userId" = "expr(object.getId())" }
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups="getClientDetails")
 * )
 * 
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "userDetails",
 *          absolute = true,
 *          parameters = { "clientId" = "expr(object.getClient().getId())", "userId" = "expr(object.getId())" }
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups={"getUserDetails"})
 * )
 *
 * @Hateoas\Relation(
 *      "viewNewUser",
 *      href = @Hateoas\Route(
 *          "userDetails",
 *          absolute = true,
 *          parameters = { "clientId" = "expr(object.getClient().getId())", "userId" = "expr(object.getId())" }
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups="addUser"),
 * )
 *
 */

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[Broadcast]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['getClientDetails', 'getUserSummary', 'getUserDetails', 'addUser'])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['getClientDetails', 'getUserSummary', 'getUserDetails', 'addUser', 'editUser'])]
    #[Assert\NotBlank(message: "username must be specified")]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    #[Groups(['getUserDetails', 'addUser', 'editUser'])]
    #[Assert\NotBlank(message: "email must be specified")]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Groups(['getUserDetails', 'addUser', 'editUser'])]
    #[Assert\NotBlank(message: "status must be specified")]
    private ?string $status = null;

    #[ORM\Column(type: "datetime")]
    #[Groups(['getUserDetails'])]
    #[Since("2.0")]
    private ?DateTime $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Client $client = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserName(): ?string
    {
        return $this->username;
    }

    public function setUserName(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;
        return $this;
    }
}
