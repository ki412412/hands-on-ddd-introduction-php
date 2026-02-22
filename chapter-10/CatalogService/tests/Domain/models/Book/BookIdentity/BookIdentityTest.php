<?php

declare(strict_types=1);

use CatalogService\Domain\models\Book\Author\Author;
use CatalogService\Domain\models\Book\BookId\BookId;
use CatalogService\Domain\models\Book\BookIdentity\BookIdentity;
use CatalogService\Domain\models\Book\Title\Title;

test('同じIDを持つエンティティは等価である', function () {
    $id = new BookId('9784798126708');
    $identity1 = new BookIdentity(
        $id,
        new Title('エリック・エヴァンスのドメイン駆動設計'),
        new Author('エリック・エヴァンス')
    );
    $identity2 = new BookIdentity(
        $id,
        new Title('エヴァンス本'),
        new Author('エヴァンス')
    );

    expect($identity1->equals($identity2))->toBeTrue();
});

test('異なるIDを持つエンティティは等価でない', function () {
    $id1 = new BookId('9784798126708');
    $id2 = new BookId('9784798131610');
    $identity1 = new BookIdentity(
        $id1,
        new Title('エリック・エヴァンスのドメイン駆動設計'),
        new Author('エリック・エヴァンス')
    );
    $identity2 = new BookIdentity(
        $id2,
        new Title('エリック・エヴァンスのドメイン駆動設計'),
        new Author('エリック・エヴァンス')
    );

    expect($identity1->equals($identity2))->toBeFalse();
});
