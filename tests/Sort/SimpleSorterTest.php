<?php

declare(strict_types=1);

use Tnt\DataList\Contracts\Sort\SortableInterface;
use Tnt\DataList\Sort\SimpleSorter;

it(
    'applies valid sort directions and falls back to the default direction',
    function (): void {
        $repository = new class implements SortableInterface {
            /**
             * @var list<array{column: string, method: string}>
             */
            public array $sorts = [];

            public function sort(
                string $column,
                string $sortMethod = 'ASC'
            ): SortableInterface {
                $this->sorts[] = ['column' => $column, 'method' => $sortMethod];

                return $this;
            }
        };

        $sorter = new SimpleSorter('created_at', 'DESC');

        $sorter->apply($repository, 'asc');
        $sorter->apply($repository, 'sideways');

        expect($repository->sorts)->toBe([
            ['column' => 'created_at', 'method' => 'ASC'],
            ['column' => 'created_at', 'method' => 'DESC'],
        ]);
    }
);
