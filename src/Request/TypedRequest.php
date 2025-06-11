<?php

declare(strict_types=1);

namespace Reinfi\TypedRequest\Request;

use Laminas\Http\PhpEnvironment\Request;
use Reinfi\TypedRequest\Parameters\TypedParameters;
use Reinfi\TypedRequest\Value\TypedValue;

class TypedRequest extends Request
{
    public function __construct($allowCustomMethods = true)
    {
        parent::__construct($allowCustomMethods);

        $this->queryParams = new TypedParameters($this->queryParams?->toArray());
    }

    /**
     * @param string|null $name
     * @param mixed|null $default
     * @return ($name is null ? TypedParameters<array-key, mixed> : TypedValue)
     */
    public function getQuery($name = null, $default = null): TypedValue|TypedParameters
    {
        assert($this->queryParams instanceof TypedParameters);

        if ($name === null) {
            return $this->queryParams;
        }

        return $this->queryParams->get($name, $default);
    }
}
