<?php

declare(strict_types=1);

namespace Reinfi\TypedRequest\Value;

use DateTimeImmutable;
use Exception;
use TypeError;
use Webmozart\Assert\Assert;

class TypedValue
{
    /** @var mixed */
    private $value;

    /** @param mixed $value */
    public function __construct($value)
    {
        $this->value = $value;
    }

    public function asBoolean(): bool
    {
        $value = $this->asBooleanOrNull();
        Assert::notNull($value);

        return $value;
    }

    public function asBooleanOrNull(): ?bool
    {
        Assert::nullOrBoolean($this->value);

        return $this->value;
    }

    public function asInteger(): int
    {
        $value = $this->asIntegerOrNull();
        Assert::notNull($value);

        return $value;
    }

    public function asIntegerOrNull(): ?int
    {
        Assert::nullOrIntegerish($this->value);

        return null !== $this->value
            ? (int) $this->value
            : null;
    }

    /** @psalm-return positive-int */
    public function asPositiveInteger(): int
    {
        $value = $this->asPositiveIntegerOrNull();
        Assert::notNull($value);

        return $value;
    }

    /**
     * @psalm-return positive-int|null
     * @psalm-suppress MoreSpecificReturnType
     */
    public function asPositiveIntegerOrNull(): ?int
    {
        $value = $this->asIntegerOrNull();
        Assert::nullOrGreaterThan($value, 0);

        /** @psalm-suppress LessSpecificReturnStatement */
        return $value;
    }

    /**
     * @psalm-return positive-int|0
     * @psalm-suppress MoreSpecificReturnType
     */
    public function asNaturalInteger(): int {
        $value = $this->asNaturalIntegerOrNull();
        Assert::notNull($value);

        return $value;
    }

    /**
     * @psalm-return positive-int|0|null
     * @psalm-suppress LessSpecificReturnStatement
     * @psalm-suppress MoreSpecificReturnType
     */
    public function asNaturalIntegerOrNull(): ?int {
        $value = $this->asIntegerOrNull();
        Assert::nullOrGreaterThanEq($value, 0);

        return $value;
    }

    public function asString(): string
    {
        $value = $this->asStringOrNull();
        Assert::string($value);

        return $value;
    }

    public function asStringOrNull(): ?string
    {
        Assert::nullOrString($this->value);

        return $this->value;
    }

    /** @psalm-return non-empty-string */
    public function asNonEmptyString(): string
    {
        $value = $this->asNonEmptyStringOrNull();
        Assert::notNull($value);

        return $value;
    }

    /** @psalm-return non-empty-string|null */
    public function asNonEmptyStringOrNull(): ?string
    {
        Assert::nullOrStringNotEmpty($this->value);

        return $this->value;
    }

    /**
     * @psalm-return list<non-empty-string>
     * @return string[]
     */
    public function asNonEmptyStrings(): array
    {
        Assert::isArray($this->value);
        Assert::allStringNotEmpty($this->value);

        return array_values($this->value);
    }

    public function asDateTimeImmutable(?string $format = null): DateTimeImmutable
    {
        $value = $this->asNonEmptyString();

        try {
            $date = $format !== null
                ? DateTimeImmutable::createFromFormat($format, $value)
                : new DateTimeImmutable($value);
        } catch (Exception $e) {
            throw new TypeError(sprintf('"%s" is not a valid date string.', $value), 412, $e);
        }

        if(!$date instanceof DateTimeImmutable) {
            if($format !== null) {
                throw new TypeError(sprintf('Invalid date "%s" with format "%s"', $value, $format), 412);
            }

            throw new TypeError(sprintf('"%s" is not a valid date string.', $value), 412);
        }

        return $date;
    }

    public function asArray(): array
    {
        $value = $this->asArrayOrNull();
        Assert::notNull($value);

        return $value;
    }

    public function asArrayOrNull(): ?array
    {
        Assert::nullOrIsArray($this->value);

        return $this->value;
    }
}
