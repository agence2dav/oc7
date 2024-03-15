<?php

declare(strict_types=1);

namespace App\Model;

use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation\Groups;

/**
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "clientSummary",
 *          parameters = {}
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups="getClients"),
 * )
 * 
 * @Hateoas\Relation(
 *      "details",
 *      href = @Hateoas\Route(
 *          "clientDetails",
 *          parameters = { "id" = "expr(object.getId())" }
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups="getClient"),
 * )
 *
 */

class ClientModel
{
    #[Groups(['getClients', 'getClient'])]
    private ?int $id = null;

    #[Groups(['getClients', 'getClient'])]
    private ?string $corporation = null;

    #[Groups(['getClient'])]
    private ?string $email = null;
    private array $links;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;
        return $this;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getLinks(): array
    {
        return $this->links;
    }

    /* 
    public function setLinks(int $id): static
    {
        $this->links = [
            '_links' => [
                'self' => (string) '/api/clients',
                'href' => (string) '/api/clients/' . $id,
            ],
            'title' => 'H.A.T.E.O.A.S & Resource Linking'
        ];
        return $this;
    }*/

}
