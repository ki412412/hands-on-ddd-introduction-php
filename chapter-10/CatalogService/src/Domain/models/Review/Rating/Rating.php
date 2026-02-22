<?php

declare(strict_types=1);

namespace CatalogService\Domain\models\Review\Rating;

use CatalogService\Domain\models\shared\ValueObject;

final class Rating extends ValueObject
{
    public const MAX = 5;
    public const MIN = 1;

    public function __construct(mixed $value)
    {
        parent::__construct($value);
    }

    protected function validate(mixed $value): void
    {
        if (!is_int($value)) {
            throw new \InvalidArgumentException('評価は整数値でなければなりません。');
        }
        if ($value < self::MIN || $value > self::MAX) {
            throw new \InvalidArgumentException(
                '評価は' . self::MIN . 'から' . self::MAX . 'までの整数値でなければなりません。'
            );
        }
    }

    public function value(): int
    {
        return parent::value();
    }

    /**
     * 評価の品質係数を返す (0.0 〜 1.0の範囲)
     */
    public function getQualityFactor(): float
    {
        return (float) (($this->value() - self::MIN) / (self::MAX - self::MIN));
    }
}
