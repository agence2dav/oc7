<?php

declare(strict_types=1);

namespace App\Service;

use Hateoas\HateoasBuilder;
use Hateoas\Configuration\Route;
use App\Service\VersioningService;
use JMS\Serializer\SerializerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\DeserializationContext;
use Doctrine\Common\Collections\Collection;
use Hateoas\UrlGenerator\SymfonyUrlGenerator;
use Hateoas\UrlGenerator\CallableUrlGenerator;
use Hateoas\Representation\PaginatedRepresentation;
use Hateoas\Representation\CollectionRepresentation;
use Hateoas\Representation\Factory\PagerfantaFactory;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SerializerJmsService
{

    public function __construct(
        private SerializerInterface $serializer,
        private VersioningService $versionService,
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

    public function hateoasSerialize(array|object $datas, UrlGeneratorInterface $request, array $groups = []): string
    {
        $context = SerializationContext::create()->setGroups($groups);
        $context->setVersion($this->versionService->getVersion());
        $hateoas = HateoasBuilder::create()
            ->setUrlGenerator(null, new SymfonyUrlGenerator($request))
            ->build();
        return $hateoas->serialize($datas, 'json', $context);
        //return $this->get('serializer')->serialize($datas, 'json');
    }

    public function paginatedCollection(array $collection, string $route, int $page, int $limit, int $total): PaginatedRepresentation
    {
        $nbPages = (int) ceil($total / $limit);
        return new PaginatedRepresentation(
            new CollectionRepresentation([$collection]),
            $route,     // route
            ['page', 'limit'],    // route parameters
            $page,      // page number
            $limit,     // limit
            $nbPages,   // total pages
            'page',     // page route parameter name, optional, defaults to 'page'
            'limit',    // limit route parameter name, optional, defaults to 'limit'
            true,       // generate relative URIs, optional, defaults to `false`
            $total      // total collection size, optional, defaults to `null`
        );
    }

    public function hateoasSerializePaginated(array $collection, UrlGeneratorInterface $request, array $groups, string $route, int $page, int $limit, int $total): string
    {
        $paginatedCollection = $this->paginatedCollection($collection, $route, $page, $limit, $total);
        return $this->hateoasSerialize($collection, $request, $groups);
    }
}
