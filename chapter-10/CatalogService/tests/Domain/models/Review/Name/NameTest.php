<?php

declare(strict_types=1);

use CatalogService\Domain\models\Review\Name\Name;

test('Nameが1文字で作成できる', function () {
    $name = new Name('a');
    expect($name->value())->toBe('a');
});

test('Nameが50文字で作成できる', function () {
    $longName = str_repeat('a', 50);
    $name = new Name($longName);
    expect($name->value())->toBe($longName);
});

test('最小長未満の値でNameを生成するとエラーを投げる', function () {
    expect(fn () => new Name(''))
        ->toThrow(InvalidArgumentException::class, '投稿者名は1文字以上、50文字以下でなければなりません。');
});

test('最大長を超える値でNameを生成するとエラーを投げる', function () {
    expect(fn () => new Name(str_repeat('a', 51)))
        ->toThrow(InvalidArgumentException::class, '投稿者名は1文字以上、50文字以下でなければなりません。');
});
