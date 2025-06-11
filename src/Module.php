<?php

declare(strict_types=1);

namespace Reinfi\TypedRequest;

use Reinfi\TypedRequest\Request\TypedRequestFactory;

class Module
{
    public function getConfig(): array
    {
        return [
            'service_manager' => [
                'factories' => [
                    'Request' => TypedRequestFactory::class,
                ],
            ]
        ];
    }
}
