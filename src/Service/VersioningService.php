<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class VersioningService
{
    private $defaultVersion;

    public function __construct(
        private RequestStack $requestStack,
        private ParameterBagInterface $params
    ) {
        $this->defaultVersion = $params->get('default_api_version');
    }

    //set Accept = application/json; version=2.0
    public function getVersion(): string
    {
        $version = $this->defaultVersion;
        $request = $this->requestStack->getCurrentRequest();
        $accept = $request->headers->get('Accept'); //version=2.0" => 2.0
        $headers = explode(';', $accept);

        foreach ($headers as $header) {
            if (strpos($header, 'version') !== false) {
                $version = explode('=', $header);
                $version = $version[1];
                break;
            }
        }
        return $version;
    }
}
