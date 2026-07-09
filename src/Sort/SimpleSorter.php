<?php

namespace Tnt\DataList\Sort;

use Tnt\DataList\Contracts\Sort\SortableInterface;

class SimpleSorter extends Sorter
{
    private string $column;

    private string $defaultSortMethod;

    public function __construct(
        string $column,
        string $defaultSortMethod = 'ASC'
    ) {
        $this->column = $column;
        $this->defaultSortMethod = strtoupper($defaultSortMethod);
    }

    public function apply(
        SortableInterface $repository,
        string $sortMethod = ''
    ): void {
        $sortMethod = strtoupper($sortMethod);

        if (!in_array($sortMethod, ['ASC', 'DESC'], true)) {
            $sortMethod = $this->defaultSortMethod;
        }

        $repository->sort($this->column, $sortMethod);
    }
}
