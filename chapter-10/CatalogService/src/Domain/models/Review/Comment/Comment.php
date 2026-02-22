<?php

declare(strict_types=1);

namespace CatalogService\Domain\models\Review\Comment;

use CatalogService\Domain\models\shared\ValueObject;

final class Comment extends ValueObject
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
                'コメントは' . self::MIN_LENGTH . '文字以上、' . self::MAX_LENGTH . '文字以下でなければなりません。'
            );
        }
    }

    public function value(): string
    {
        return parent::value();
    }

    /**
     * コメントの品質係数を返す (0.0 〜 1.0の範囲)
     */
    public function getQualityFactor(): float
    {
        $minLength = 10;
        $optimalLength = 100;
        $length = mb_strlen(trim($this->value()), 'UTF-8');
        if ($length < $minLength) {
            return 0.2;
        }
        if ($length >= $optimalLength) {
            return 1.0;
        }
        return 0.2 + 0.8 * (($length - $minLength) / ($optimalLength - $minLength));
    }

    /**
     * 文字列パターンにマッチする部分を抽出する（キャプチャグループ1を返す）
     * @return string[]
     */
    public function extractMatches(string $pattern): array
    {
        $text = $this->value();
        $count = preg_match_all($pattern, $text, $matches, PREG_SET_ORDER);
        if ($count === false) {
            return [];
        }
        $results = [];
        foreach ($matches as $m) {
            if (isset($m[1])) {
                $results[] = $m[1];
            }
        }
        return $results;
    }
}
