<?php

declare(strict_types=1);

namespace App\Model;

use Doctrine\Common\Collections\Collection;

class DeviceDetailsModel
{
    private ?int $id = null;
    private ?string $name = null;
    private ?string $url = null;
    private ?string $image = null;
    private ?int $status = null;
    private array $links;
    private Collection $deviceProps;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;
        return $this;
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

    public function setDeviceUrl(int $id): static
    {
        $this->links = [
            'href' => (string) '/api/devices/' . $id . '/details'
        ];
        return $this;
    }

    public function getDeviceProps(): Collection
    {
        return $this->deviceProps;
    }

    public function setDeviceProps(Collection $deviceProps): static
    {
        $this->deviceProps = $deviceProps;
        return $this;
    }
}
