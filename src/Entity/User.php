<?php

namespace App\Entity;

use DateTime;
use Assert\NotBlank;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\UX\Turbo\Attribute\Broadcast;
//use Symfony\Component\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * 
 * @Hateoas\Relation(
 *      "userDetails",
 *      href = @Hateoas\Route(
 *          "userDetails",
 *          parameters = { "clientId" = "expr(object.getClient().getId())", "userId" = "expr(object.getId())" }
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups="getUserSummary")
 * )
 *
 * @Hateoas\Relation(
 *      "delete",
 *      href = @Hateoas\Route(
 *          "delUser",
 *          parameters = { "id" = "expr(object.getId())" },
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups="getUserDetails"),
 * )
 *
 * @Hateoas\Relation(
 *      "update",
 *      href = @Hateoas\Route(
 *          "updateUser",
 *          parameters = { "id" = "expr(object.getId())" },
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups="getUserDetails"),
 * )
 *
 * @Hateoas\Relation(
 *      "create",
 *      href = @Hateoas\Route(
 *          "addUser",
 *          parameters = { },
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups="getUserDetails"),
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
    #[Groups(['getClientDetails', 'getUserSummary', 'getUserDetails'])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['getClientDetails', 'getUserSummary', 'getUserDetails'])]
    #[Assert\NotBlank(message: "must be specified")]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    #[Groups(['getUserDetails'])]
    #[Assert\NotBlank(message: "must be specified")]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Groups(['getClientDetails', 'getUserDetails'])]
    #[Assert\NotBlank(message: "must be specified")]
    private ?string $status = null;

    #[ORM\Column(type: "datetime")]
    #[Groups(['getClientDetails', 'getUserDetails'])]
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
