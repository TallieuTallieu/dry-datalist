<?php

namespace Tnt\DataList\Paginate;

use Tnt\DataList\Contracts\Paginate\PaginatableInterface;
use Tnt\Dbi\Criteria\LimitOffset;

trait PaginatableTrait
{
	public function paginate(int $currentPage = 1, int $perPage = 30): PaginatableInterface
	{
		$offset = $perPage * ($currentPage - 1);

		$this->addCriteria(new LimitOffset($perPage, $offset));

		return $this;
	}
}