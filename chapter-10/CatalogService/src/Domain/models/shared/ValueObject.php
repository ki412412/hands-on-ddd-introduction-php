<?php

declare(strict_types=1);

namespace CatalogService\Domain\models\shared;

abstract class ValueObject
{
    protected readonly mixed $value;

    public function __construct(mixed $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    abstract protected function validate(mixed $value): void;

    public function value(): mixed
    {
        return $this->value;
    }

    public function equals(ValueObject $other): bool
    {
        $a = $this->value;
        $b = $other->value;
        if (is_array($a) && is_array($b)) {
            return $a == $b;
        }
        if (is_object($a) && is_object($b)) {
            return $a == $b;
        }
        return $a === $b;
    }
}
