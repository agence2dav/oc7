<?php

declare(strict_types=1);

namespace App\Service;

use Hateoas\HateoasBuilder;
use JMS\Serializer\SerializerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\DeserializationContext;

class SerializerJmsService
{

    public function __construct(
        private SerializerInterface $serializer,
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
