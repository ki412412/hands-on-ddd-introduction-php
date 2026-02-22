<?php

declare(strict_types=1);

use CatalogService\Domain\models\Review\Rating\Rating;

test('有効な値を持つRatingを作成できる', function () {
    expect((new Rating(1))->value())->toBe(1);
    expect((new Rating(3))->value())->toBe(3);
    expect((new Rating(5))->value())->toBe(5);
});

test('Equals', function () {
    $rating1 = new Rating(3);
    $rating2 = new Rating(3);
    $rating3 = new Rating(4);
    expect($rating1->equals($rating2))->toBeTrue();
    expect($rating1->equals($rating3))->toBeFalse();
});

test('GetQualityFactor_1から5の範囲で正しく変換できる', function () {
    expect((new Rating(1))->getQualityFactor())->toBe(0.0);
    expect((new Rating(3))->getQualityFactor())->toBe(0.5);
    expect((new Rating(5))->getQualityFactor())->toBe(1.0);
});

test('最小値未満の値でRatingを生成するとエラーを投げる', function () {
    expect(fn () => new Rating(0))
        ->toThrow(InvalidArgumentException::class, '評価は1から5までの整数値でなければなりません。');
});

test('最大値を超える値でRatingを生成するとエラーを投げる', function () {
    expect(fn () => new Rating(6))
        ->toThrow(InvalidArgumentException::class, '評価は1から5までの整数値でなければなりません。');
});

test('小数値でRatingを生成するとエラーを投げる', function () {
    expect(fn () => new Rating(3.5))
        ->toThrow(InvalidArgumentException::class, '評価は整数値でなければなりません。');
});
