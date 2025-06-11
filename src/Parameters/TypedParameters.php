<?php

declare(strict_types=1);

namespace Reinfi\TypedRequest\Parameters;

use IteratorAggregate;
use Laminas\Stdlib\Parameters;
use Laminas\Stdlib\ParametersInterface;
use Reinfi\TypedRequest\Value\TypedValue;
use ReturnTypeWillChange;

/**
 * @template TKey of array-key
 * @template TValue
 * @template-implements ParametersInterface<TKey, TValue>
 */
class TypedParameters implements ParametersInterface, IteratorAggregate
{
    /**
     * @var Parameters<TKey, TValue>
     */
    private Parameters $parameters;

    public function offsetExists($offset): bool
    {
        return $this->parameters->offsetExists($offset);
    }

    public function offsetGet($offset): TypedValue
    {
        return new TypedValue($this->parameters->offsetGet($offset));
    }

    public function offsetSet($offset, $value): void
    {
        $this->parameters->offsetSet($offset, $value);
    }

    public function offsetUnset($offset): void
    {
        $this->parameters->offsetUnset($offset);
    }

    public function serialize(): string
    {
        return $this->parameters->serialize();
    }

    public function unserialize(string $data): void
    {
        $this->parameters->unserialize($data);
    }

    public function __serialize(): array
    {
        return $this->parameters->serialize();
    }

    public function __unserialize(array $data): void
    {

    }

    public function count(): int
    {
        return $this->parameters->count();
    }

    public function __construct(?array $values = null)
    {
        $this->parameters = new Parameters($values);
    }

    public function fromArray(array $values): void
    {
        $this->parameters->fromArray($values);
    }

    public function fromString($string): void
    {
        $this->parameters->fromString($string);
    }

    public function toArray(): array
    {
        return $this->parameters->toArray();
    }

    public function toString(): string
    {
        return $this->parameters->toString();
    }

    public function get($name, $default = null): TypedValue
    {
        return new TypedValue($this->parameters->get($name, $default));
    }

    public function set($name, $value): void
    {
        $this->parameters->set($name, $value);
    }

    #[ReturnTypeWillChange]
    public function getIterator()
    {
        return $this->parameters->getIterator();
    }
}
