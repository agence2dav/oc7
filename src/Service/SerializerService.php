<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class SerializerService
{

    public function __construct(
        private SerializerInterface $serializer,
    ) {

    }

    public function json(array $datas): string
    {
        $serializer = new Serializer([], [new JsonEncoder()]);
        return $serializer->encode($datas, 'json');
    }

    public function entityToJson(object $object): string
    {
        return $this->serializer->serialize($object, 'json');
    }

    public function entitiesToJson(array $datas): string
    {
        return $this->serializer->serialize($datas, 'json');
    }

}
