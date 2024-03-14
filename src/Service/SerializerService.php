<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\DeserializationContext;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class SerializerService
{

    public function __construct(
        private Serializer $serializer,
        private SerializerInterface $interface,
        private SerializationContext $context,
        private DeserializationContext $deserializationContext,
    ) {

    }

    public function serialize(array|object $datas, array $groups = []): string
    {
        $context = $this->context::create()->setGroups($groups);
        return $this->serializer->serialize($datas, 'json', $context);
    }

    public function deserialize(string $content, string $class, array $options = []): object
    {
        $context = $this->deserializationContext::create()->setGroups($options);
        return $this->serializer->deserialize($content, $class, 'json', $context);
    }

}
