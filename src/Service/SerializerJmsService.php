<?php

declare(strict_types=1);

namespace App\Service;

use Hateoas\HateoasBuilder;
use JMS\Serializer\SerializerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\DeserializationContext;
use Doctrine\Common\Collections\Collection;
use Hateoas\UrlGenerator\SymfonyUrlGenerator;
use Hateoas\UrlGenerator\CallableUrlGenerator;
use Hateoas\Representation\PaginatedRepresentation;
use Hateoas\Representation\CollectionRepresentation;

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

    public function hateoasSerialize(array|object $datas, $request, string $route): string
    {
        //$hateoas = HateoasBuilder::create()->build();
        $hateoas = HateoasBuilder::create()
            ->setUrlGenerator(null, new SymfonyUrlGenerator($request))
            ->build()
        ;
        return $hateoas->serialize($datas, 'json');
        //return $this->get('serializer')->serialize($datas, 'json');
    }

    public function hateoasSerializePaginated(array $collection, string $route, int $page, int $limit): string
    {
        $nbObjects = count($collection);
        $nbPages = (int) ceil($nbObjects / $limit);
        $paginatedCollection = new PaginatedRepresentation(
            new CollectionRepresentation([$collection]),
            $route,     // route
            array(),    // route parameters
            $page,      // page number
            $limit,     // limit
            $nbPages,  // total pages
            'page',     // page route parameter name, optional, defaults to 'page'
            'limit',    // limit route parameter name, optional, defaults to 'limit'
            false,      // generate relative URIs, optional, defaults to `false`
            $nbObjects  // total collection size, optional, defaults to `null`
        );
        $hateoas = HateoasBuilder::create()->build();
        return $hateoas->serialize($paginatedCollection, 'json');
    }

    public function serializeok($data, string $format, ?SerializationContext $context = null, ?string $type = null): string
    {
        return $this->serializer->serialize($data, $format, $context, $type);
    }

}
