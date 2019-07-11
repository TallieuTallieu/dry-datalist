<?php

namespace Tnt\DataList\Contracts\Sort;

interface SortableInterface
{
	public function sort($column, string $sortMethod = 'ASC'): SortableInterface;
}