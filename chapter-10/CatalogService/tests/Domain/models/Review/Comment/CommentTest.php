<?php

declare(strict_types=1);

use CatalogService\Domain\models\Review\Comment\Comment;

test('Commentが1文字で作成できる', function () {
    $comment = new Comment('a');
    expect($comment->value())->toBe('a');
});

test('Commentが1000文字で作成できる', function () {
    $longComment = str_repeat('a', 1000);
    $comment = new Comment($longComment);
    expect($comment->value())->toBe($longComment);
});

test('最小長未満の値でCommentを生成するとエラーを投げる', function () {
    expect(fn () => new Comment(''))
        ->toThrow(InvalidArgumentException::class, 'コメントは1文字以上、1000文字以下でなければなりません。');
});

test('最大長を超える値でCommentを生成するとエラーを投げる', function () {
    expect(fn () => new Comment(str_repeat('a', 1001)))
        ->toThrow(InvalidArgumentException::class, 'コメントは1文字以上、1000文字以下でなければなりません。');
});

test('GetQualityFactor_短いコメントの品質係数が正しく計算される', function () {
    $comment = new Comment('短すぎる');
    expect(mb_strlen($comment->value(), 'UTF-8'))->toBeLessThan(10);
    expect($comment->getQualityFactor())->toBe(0.2);
});

test('GetQualityFactor_十分な長さのコメントの品質係数が正しく計算される', function () {
    $longEnoughComment = str_repeat('a', 100);
    $comment = new Comment($longEnoughComment);
    expect($comment->getQualityFactor())->toBe(1.0);
});

test('GetQualityFactor_中間の長さのコメントの品質係数が正しく計算される', function () {
    $mediumComment = str_repeat('a', 50);
    $comment = new Comment($mediumComment);
    expect($comment->getQualityFactor())->toEqualWithDelta(0.56, 0.01);
});

test('ExtractMatches_指定したパターンに一致する文字列を抽出できる', function () {
    $comment = new Comment('この本は#素晴らしい です。#おすすめ #買って損なし');
    $matches = $comment->extractMatches('/#([^\s]+)/u');
    expect($matches)->toBe(['素晴らしい', 'おすすめ', '買って損なし']);
});

test('ExtractMatches_一致するパターンがない場合は空配列を返す', function () {
    $comment = new Comment('特別なパターンはありません');
    $matches = $comment->extractMatches('/#([^\s]+)/u');
    expect($matches)->toBe([]);
});
