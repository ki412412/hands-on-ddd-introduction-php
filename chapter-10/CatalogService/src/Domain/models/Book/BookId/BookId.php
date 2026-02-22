<?php

declare(strict_types=1);

namespace CatalogService\Domain\models\Book\BookId;

use CatalogService\Domain\models\shared\ValueObject;

final class BookId extends ValueObject
{
    public const MAX_LENGTH = 13;
    public const MIN_LENGTH = 10;

    public function __construct(string $value)
    {
        parent::__construct($value);
    }

    protected function validate(mixed $value): void
    {
        $len = strlen($value);
        if ($len < self::MIN_LENGTH || $len > self::MAX_LENGTH) {
            throw new \InvalidArgumentException('ISBNの文字数が不正です');
        }
        if (!$this->isValidIsbn10($value) && !$this->isValidIsbn13($value)) {
            throw new \InvalidArgumentException('不正なISBNの形式です');
        }
    }

    private function isValidIsbn10(string $isbn10): bool
    {
        return strlen($isbn10) === 10;
    }

    private function isValidIsbn13(string $isbn13): bool
    {
        return str_starts_with($isbn13, '978') && strlen($isbn13) === 13;
    }

    public function value(): string
    {
        return parent::value();
    }

    public function toISBN(): string
    {
        $v = $this->value();
        if (strlen($v) === 10) {
            $groupIdentifier = substr($v, 0, 1);
            $publisherCode = substr($v, 1, 2);
            $bookCode = substr($v, 3, 6);
            $checksum = substr($v, 9, 1);
            return 'ISBN' . $groupIdentifier . '-' . $publisherCode . '-' . $bookCode . '-' . $checksum;
        }
        $isbnPrefix = substr($v, 0, 3);
        $groupIdentifier = substr($v, 3, 1);
        $publisherCode = substr($v, 4, 2);
        $bookCode = substr($v, 6, 6);
        $checksum = substr($v, 12, 1);
        return 'ISBN' . $isbnPrefix . '-' . $groupIdentifier . '-' . $publisherCode . '-' . $bookCode . '-' . $checksum;
    }
}
