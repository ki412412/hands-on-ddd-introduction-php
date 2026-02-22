<?php

declare(strict_types=1);

namespace CatalogService\Domain\models\Review\ReviewId;

use CatalogService\Domain\models\shared\ValueObject;

final class ReviewId extends ValueObject
{
    public const MAX_LENGTH = 100;
    public const MIN_LENGTH = 1;

    public function __construct(?string $value = null)
    {
        parent::__construct($value ?? self::generateId());
    }

    private static function generateId(): string
    {
        return bin2hex(random_bytes(16));
    }

    protected function validate(mixed $value): void
    {
        $len = mb_strlen($value, 'UTF-8');
        if ($len < self::MIN_LENGTH || $len > self::MAX_LENGTH) {
            throw new \InvalidArgumentException(
                'ReviewIdは' . self::MIN_LENGTH . '文字以上、' . self::MAX_LENGTH . '文字以下でなければなりません。'
            );
        }
    }

    public function value(): string
    {
        return parent::value();
    }
}
