<?php

namespace Tnt\DataList\Contracts\Sort;

interface SortableInterface
{
    public function sort(
        string $column,
        string $sortMethod = 'ASC'
    ): SortableInterface;
}
