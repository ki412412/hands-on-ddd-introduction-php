<?php

declare(strict_types=1);

use CatalogService\Domain\models\Book\BookId\BookId;

test('有効なフォーマットの場合正しい変換結果を期待', function () {
    $bookId = new BookId('9784798126708');
    expect($bookId->value())->toBe('9784798126708');
});

test('Equals', function () {
    $bookId1 = new BookId('9784798126708');
    $bookId2 = new BookId('9784798126708');
    $bookId3 = new BookId('9781234567890');
    expect($bookId1->equals($bookId2))->toBeTrue();
    expect($bookId1->equals($bookId3))->toBeFalse();
});

test('ToISBN_13桁', function () {
    $bookId = new BookId('9784798126708');
    expect($bookId->toISBN())->toBe('ISBN978-4-79-812670-8');
});

test('ToISBN_10桁', function () {
    $bookId = new BookId('4167158051');
    expect($bookId->toISBN())->toBe('ISBN4-16-715805-1');
});

test('不正な文字数の場合にエラーを投げる', function () {
    expect(fn () => new BookId(str_repeat('1', 101)))
        ->toThrow(InvalidArgumentException::class, 'ISBNの文字数が不正です');
});

test('不正な文字数9桁でエラーを投げる', function () {
    expect(fn () => new BookId(str_repeat('1', 9)))
        ->toThrow(InvalidArgumentException::class, 'ISBNの文字数が不正です');
});

test('不正なフォーマットの場合にエラーを投げる', function () {
    expect(fn () => new BookId('9994167158057'))
        ->toThrow(InvalidArgumentException::class, '不正なISBNの形式です');
});
