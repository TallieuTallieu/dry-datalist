<?php

namespace Tnt\DataList\Filter;

use Tnt\DataList\Contracts\Filter\FilterableInterface;
use Tnt\DataList\Filter\Criteria\OrEquals;

trait FilterableTrait
{
	public function filter($column, array $values): FilterableInterface
	{
		$this->addCriteria(new OrEquals($column, $values));

		return $this;
	}
}