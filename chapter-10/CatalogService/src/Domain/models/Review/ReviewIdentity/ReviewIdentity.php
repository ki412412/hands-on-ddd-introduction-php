<?php

declare(strict_types=1);

namespace CatalogService\Domain\models\Review\ReviewIdentity;

use CatalogService\Domain\models\Review\ReviewId\ReviewId;

final class ReviewIdentity
{
    public function __construct(
        private readonly ReviewId $reviewId
    ) {
    }

    /** 同一性判定 */
    public function equals(self $other): bool
    {
        return $this->reviewId->equals($other->reviewId);
    }

    public function getReviewId(): ReviewId
    {
        return $this->reviewId;
    }
}
