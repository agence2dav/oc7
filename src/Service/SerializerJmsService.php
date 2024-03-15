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
        private SerializerInterface $serializer,
        //private SerializationContext $context,
        //private DeserializationContext $deserializationContext,
    ) {

    }

    public function serialize(
        array|object $datas,
        array $groups = [],
    ): string {
        $context = SerializationContext::create()->setGroups($groups);
        return $this->serializer->serialize($datas, 'json', $context);
    }

    public function deserialize(
        string $content,
        string $class,
        array $options = [],
    ): object {
        $context = DeserializationContext::create()->setGroups($options);
        return $this->serializer->deserialize($content, $class, 'json', $context);
    }

    /* */
    //$datas = new User(42, 'Adrien', 'Brault', new User(23, 'Will', 'Durand'));
    public function hateoasSerialize(array|object $datas): string
    {
        $hateoas = HateoasBuilder::create()->build();
        return $hateoas->serialize($datas, 'json');
    }

}
