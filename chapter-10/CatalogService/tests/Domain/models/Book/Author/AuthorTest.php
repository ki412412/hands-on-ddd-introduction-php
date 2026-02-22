<?php

declare(strict_types=1);

use CatalogService\Domain\models\Book\Author\Author;

test('Authorが1文字で作成できる', function () {
    $author = new Author('山');
    expect($author->value())->toBe('山');
});

test('Authorが100文字で作成できる', function () {
    $longName = str_repeat('山', 100);
    $author = new Author($longName);
    expect($author->value())->toBe($longName);
});

test('最小長未満の値でAuthorを生成するとエラーを投げる', function () {
    expect(fn () => new Author(''))
        ->toThrow(InvalidArgumentException::class, '著者名は1文字以上、100文字以下でなければなりません。');
});

test('最大長を超える値でAuthorを生成するとエラーを投げる', function () {
    expect(fn () => new Author(str_repeat('山', 101)))
        ->toThrow(InvalidArgumentException::class, '著者名は1文字以上、100文字以下でなければなりません。');
});
