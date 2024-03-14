<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use Hateoas\HateoasBuilder;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerInterface;
use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\DeserializationContext;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class SerializerJmsService
{

    public function __construct(
        //private Serializer $serializer,
        //private SerializerInterface $interface,
        //private SerializationContext $context,
        //private DeserializationContext $deserializationContext,
    ) {

    }

    public function serialize(
        array|object $datas,
        array $groups = [],
        SerializerInterface $serializer = null
    ): string {
        $context = SerializationContext::create()->setGroups($groups);
        //return $this->serializer->serialize($datas, 'json', $context);
        return $serializer->serialize($datas, 'json', $context);
    }

    public function deserialize(
        string $content,
        string $class,
        array $options = [],
        SerializerInterface $serializer = null
    ): object {
        $context = DeserializationContext::create()->setGroups($options);
        //return $this->serializer->deserialize($content, $class, 'json', $context);
        return $serializer->deserialize($content, $class, 'json', $context);
    }

    /* */
    public function hateoasSerialize(array|object $datas): string
    {
        $hateoas = HateoasBuilder::create()->build();
        //$user = new User(42, 'Adrien', 'Brault', new User(23, 'Will', 'Durand'));
        return $hateoas->serialize($datas, 'json');
    }

}
