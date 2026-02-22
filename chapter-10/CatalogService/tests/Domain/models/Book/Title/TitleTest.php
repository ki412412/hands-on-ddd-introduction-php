<?php

declare(strict_types=1);

use CatalogService\Domain\models\Book\Title\Title;

test('Titleが1文字で作成できる', function () {
    $title = new Title('a');
    expect($title->value())->toBe('a');
});

test('Titleが1000文字で作成できる', function () {
    $longTitle = str_repeat('a', 1000);
    $title = new Title($longTitle);
    expect($title->value())->toBe($longTitle);
});

test('最小長以上の値でTitleを生成するとエラーを投げる', function () {
    expect(fn () => new Title(''))
        ->toThrow(InvalidArgumentException::class, 'タイトルは1文字以上、1000文字以下でなければなりません。');
});

test('最大長以上の値でTitleを生成するとエラーを投げる', function () {
    expect(fn () => new Title(str_repeat('a', 1001)))
        ->toThrow(InvalidArgumentException::class, 'タイトルは1文字以上、1000文字以下でなければなりません。');
});
