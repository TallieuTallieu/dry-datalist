<?php

declare(strict_types=1);

use Tnt\DataList\Url\Builder;

it('builds URLs with scalar and repeated array parameters', function (): void {
    $builder = new Builder('/items');

    $builder->setParam('page', 2);
    $builder->setParam('status', ['active', 'draft']);

    expect($builder->build())->toBe(
        '/items?page=2&status[]=active&status[]=draft'
    );
});

it('adds fluent parameters on a cloned builder', function (): void {
    $builder = new Builder('/items');

    $withSort = $builder->withParam('sort', 'name');

    expect($withSort->build())->toBe('/items?sort=name');
    expect($builder->build())->toBe('/items?');
});
