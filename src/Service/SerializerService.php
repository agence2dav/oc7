<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class SerializerService
{

    public function __construct(
        private SerializerInterface $serializer,
    ) {

    }

    public function serialize(array|object $datas, array $groups = []): string
    {
        return $this->serializer->serialize($datas, 'json', $groups);
    }

    public function deserialize(string $content, string $class, array $options = []): object
    {
        return $this->serializer->deserialize($content, $class, 'json', $options);
        ;
    }

}
