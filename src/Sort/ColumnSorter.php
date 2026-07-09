<?php

namespace Tnt\DataList\Sort;

use Tnt\DataList\Contracts\Sort\SortableInterface;

class ColumnSorter extends Sorter
{
    protected string $defaultSortString;

    /**
     * @var non-empty-string
     */
    protected string $separator;

    /**
     * @param non-empty-string $separator
     */
    public function __construct(
        string $defaultSortString = '',
        string $separator = '-'
    ) {
        $this->defaultSortString = strtoupper($defaultSortString);
        $this->separator = $separator;
    }

    public function apply(
        SortableInterface $repository,
        string $sortString = ''
    ): void {
        if (empty($sortString)) {
            $sortString = $this->defaultSortString;
        }

        $sortDefinition = explode($this->separator, $sortString);

        if (count($sortDefinition) !== 2) {
            return;
        }

        $sortColumn = $sortDefinition[0];
        $sortDirection = strtoupper($sortDefinition[1]);

        if (!in_array($sortDirection, ['ASC', 'DESC'], true)) {
            return;
        }

        $repository->sort($sortColumn, $sortDirection);
    }
}
