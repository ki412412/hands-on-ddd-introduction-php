<?php

declare(strict_types=1);

use CatalogService\Domain\models\Review\ReviewId\ReviewId;
use CatalogService\Domain\models\Review\ReviewIdentity\ReviewIdentity;

test('同じIDを持つエンティティは等価である', function () {
    $id = new ReviewId('sameIdValue');
    $identity1 = new ReviewIdentity($id);
    $identity2 = new ReviewIdentity($id);

    expect($identity1->equals($identity2))->toBeTrue();
});

test('異なるIDを持つエンティティは等価でない', function () {
    $id1 = new ReviewId();
    $id2 = new ReviewId();
    $identity1 = new ReviewIdentity($id1);
    $identity2 = new ReviewIdentity($id2);

    expect($identity1->equals($identity2))->toBeFalse();
});
