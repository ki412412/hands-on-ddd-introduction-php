<?php

declare(strict_types=1);

use CatalogService\Domain\models\Book\Price\Price;

test('正しい値と通貨コードJPYで有効なPriceを作成する', function () {
    $validAmount = 500;
    $price = new Price(['amount' => $validAmount, 'currency' => 'JPY']);
    expect($price->amount())->toBe($validAmount);
    expect($price->currency())->toBe('JPY');
});

test('無効な通貨コードの場合エラーを投げる', function () {
    expect(fn () => new Price(['amount' => 500, 'currency' => 'USD']))
        ->toThrow(InvalidArgumentException::class, '現在は日本円のみを扱います。');
});

test('MIN未満の値でPriceを生成するとエラーを投げる', function () {
    expect(fn () => new Price(['amount' => Price::MIN - 1, 'currency' => 'JPY']))
        ->toThrow(InvalidArgumentException::class, '価格は1円から1000000円の間でなければなりません。');
});

test('MAX超の値でPriceを生成するとエラーを投げる', function () {
    expect(fn () => new Price(['amount' => Price::MAX + 1, 'currency' => 'JPY']))
        ->toThrow(InvalidArgumentException::class, '価格は1円から1000000円の間でなければなりません。');
});
