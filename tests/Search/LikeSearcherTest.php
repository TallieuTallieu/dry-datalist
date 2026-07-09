<?php

declare(strict_types=1);

use Tnt\DataList\Contracts\Search\SearchableInterface;
use Tnt\DataList\Search\LikeSearcher;

it('passes configured columns and the search value to the repository', function (): void {
    $repository = new class implements SearchableInterface {
        /**
         * @var list<array{columns: array<string>, value: string}>
         */
        public array $searches = [];

        public function search(array $columns, string $value): SearchableInterface
        {
            $this->searches[] = ['columns' => $columns, 'value' => $value];

            return $this;
        }
    };

    $searcher = new LikeSearcher(['name', 'description']);

    $searcher->apply($repository, 'boots');

    expect($repository->searches)->toBe([
        ['columns' => ['name', 'description'], 'value' => 'boots'],
    ]);
});
