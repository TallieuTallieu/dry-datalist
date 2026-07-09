<?php

declare(strict_types=1);

use Tnt\DataList\Contracts\Filter\FilterableInterface;
use Tnt\DataList\Filter\EqualsFilter;

it('applies string and integer values as single-value equality filters', function (): void {
    $repository = new class implements FilterableInterface {
        /**
         * @var list<array{column: string, values: array<int|string>}>
         */
        public array $filters = [];

        public function filter(string $column, array $values): FilterableInterface
        {
            $this->filters[] = ['column' => $column, 'values' => $values];

            return $this;
        }
    };

    $filter = new EqualsFilter('status');

    $filter->apply($repository, 'active');
    $filter->apply($repository, 10);
    $filter->apply($repository, ['ignored']);

    expect($repository->filters)->toBe([
        ['column' => 'status', 'values' => ['active']],
        ['column' => 'status', 'values' => ['10']],
    ]);
});
