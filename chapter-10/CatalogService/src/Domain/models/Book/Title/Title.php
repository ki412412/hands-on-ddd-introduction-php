<?php

declare(strict_types=1);

namespace CatalogService\Domain\models\Book\Title;

use CatalogService\Domain\models\shared\ValueObject;

final class Title extends ValueObject
{
    public const MAX_LENGTH = 1000;
    public const MIN_LENGTH = 1;

    public function __construct(string $value)
    {
        parent::__construct($value);
    }

    protected function validate(mixed $value): void
    {
        $len = mb_strlen($value, 'UTF-8');
        if ($len < self::MIN_LENGTH || $len > self::MAX_LENGTH) {
            throw new \InvalidArgumentException(
                'タイトルは' . self::MIN_LENGTH . '文字以上、' . self::MAX_LENGTH . '文字以下でなければなりません。'
            );
        }
    }

    public function value(): string
    {
        return parent::value();
    }
}
