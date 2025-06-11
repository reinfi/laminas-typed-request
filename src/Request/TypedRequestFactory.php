<?php

declare(strict_types=1);

namespace Reinfi\TypedRequest\Request;

class TypedRequestFactory
{
    public function __invoke(): TypedRequest
    {
        return new TypedRequest();
    }
}
