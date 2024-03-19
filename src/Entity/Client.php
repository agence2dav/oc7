<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientRepository;
use JMS\Serializer\Annotation\Since;
use JMS\Serializer\Annotation\Groups;
use Symfony\UX\Turbo\Attribute\Broadcast;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Hateoas\Configuration\Annotation as Hateoas;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * 
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route("clientsList", absolute = true,),
 *      exclusion = @Hateoas\Exclusion(groups="getClientsList"),
 * )
 *
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route("clientSummary", absolute = true,),
 *      exclusion = @Hateoas\Exclusion(groups="getClientSummary"),
 * )
 *
 * @Hateoas\Relation(
 *      "clientSummary",
 *      href = @Hateoas\Route(
 *          "clientDetails",
 *          absolute = true,
 *          parameters = { "id" = "expr(object.getId())" }
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups="getClientSummary"),
 * )
 *
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "clientDetails",
 *          absolute = true,
 *          parameters = { "id" = "expr(object.getId())" }
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups="getClientDetails"),
 * )
 *
 */

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'This email already exists')]
#[Broadcast]
class Client implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['getClientsList', 'getClientSummary', 'getClientDetails', 'notit'])]
    public ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Groups(['getClientSummary', 'getClientDetails'])]
    #[Since("2.0")]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    #[Groups(['getClientsList', 'getClientSummary', 'getClientDetails'])]
    private ?string $corporation = null;

    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'client')]
    #[Groups(['getClientDetails'])]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getCorporation(): ?string
    {
        return $this->corporation;
    }

    public function setCorporation(string $corporation): static
    {
        $this->corporation = $corporation;

        return $this;
    }

    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setClient($this);
        }
        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getClient() === $this) {
                $user->setClient(null);
            }
        }
        return $this;
    }
}
