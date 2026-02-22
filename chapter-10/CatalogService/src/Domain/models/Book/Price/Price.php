<?php

declare(strict_types=1);

namespace CatalogService\Domain\models\Book\Price;

use CatalogService\Domain\models\shared\ValueObject;

final class Price extends ValueObject
{
    public const MAX = 1000000;
    public const MIN = 1;

    /** @param array{amount: int, currency: 'JPY'} $value */
    public function __construct(array $value)
    {
        parent::__construct($value);
    }

    protected function validate(mixed $value): void
    {
        if (!is_array($value) || ($value['currency'] ?? null) !== 'JPY') {
            throw new \InvalidArgumentException('現在は日本円のみを扱います。');
        }
        $amount = $value['amount'] ?? 0;
        if ($amount < self::MIN || $amount > self::MAX) {
            throw new \InvalidArgumentException(
                '価格は' . self::MIN . '円から' . self::MAX . '円の間でなければなりません。'
            );
        }
    }

    public function amount(): int
    {
        return $this->value['amount'];
    }

    public function currency(): string
    {
        return $this->value['currency'];
    }
}
