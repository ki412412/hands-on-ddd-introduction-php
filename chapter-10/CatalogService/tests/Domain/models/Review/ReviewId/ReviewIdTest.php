<?php

declare(strict_types=1);

use CatalogService\Domain\models\Review\ReviewId\ReviewId;

test('デフォルトの値でReviewIdを生成する', function () {
    $reviewId = new ReviewId();
    $value = $reviewId->value();
    expect(strlen($value))->toBeGreaterThanOrEqual(ReviewId::MIN_LENGTH);
    expect(strlen($value))->toBeLessThanOrEqual(ReviewId::MAX_LENGTH);
    expect($value)->not->toBeEmpty();
});

test('指定された値でReviewIdを生成する', function () {
    $value = 'customId';
    $reviewId = new ReviewId($value);
    expect($reviewId->value())->toBe($value);
});

test('最小長以下の値でReviewIdを生成するとエラーを投げる', function () {
    expect(fn () => new ReviewId(''))
        ->toThrow(InvalidArgumentException::class, 'ReviewIdは' . ReviewId::MIN_LENGTH . '文字以上、' . ReviewId::MAX_LENGTH . '文字以下でなければなりません。');
});

test('最大長以上の値でReviewIdを生成するとエラーを投げる', function () {
    expect(fn () => new ReviewId(str_repeat('a', ReviewId::MAX_LENGTH + 1)))
        ->toThrow(InvalidArgumentException::class, 'ReviewIdは' . ReviewId::MIN_LENGTH . '文字以上、' . ReviewId::MAX_LENGTH . '文字以下でなければなりません。');
});
