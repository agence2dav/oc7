<?php

declare(strict_types=1);

namespace App\Model;

class DeviceModel
{
    private int $id;
    private string $name;
    private string $url;
    private string $image;
    private int $status;
    private array $deviceProps;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
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

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;
        return $this;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function getDeviceProps(): array
    {
        return $this->deviceProps;
    }

    public function setDeviceProps(array $deviceProps): static
    {
        $this->deviceProps = $deviceProps;
        return $this;
    }

}
