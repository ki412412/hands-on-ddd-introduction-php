<?php

declare(strict_types=1);

namespace CatalogService\Domain\models\Book\BookIdentity;

use CatalogService\Domain\models\Book\Author\Author;
use CatalogService\Domain\models\Book\BookId\BookId;
use CatalogService\Domain\models\Book\Title\Title;

final class BookIdentity
{
    public function __construct(
        private readonly BookId $bookId,
        private readonly Title $title,
        private readonly Author $author
    ) {
    }

    /** 同一性判定（IDのみで判定） */
    public function equals(self $other): bool
    {
        return $this->bookId->equals($other->bookId);
    }

    public function getBookId(): BookId
    {
        return $this->bookId;
    }

    public function getTitle(): Title
    {
        return $this->title;
    }

    public function getAuthor(): Author
    {
        return $this->author;
    }
}
