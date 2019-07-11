<?php

namespace Tnt\DataList\Sort;

use Tnt\DataList\Contracts\Sort\SortableInterface;
use Tnt\Dbi\Criteria\OrderBy;

trait SortableTrait
{
	public function sort($column, string $sortMethod = 'ASC'): SortableInterface
	{
		$this->addCriteria(new OrderBy($column, $sortMethod));

		return $this;
	}
}