<?php

namespace Tnt\DataList\Filter;

use Tnt\DataList\Contracts\Filter\FilterableInterface;
use Tnt\Dbi\Criteria\Equals;

trait FilterableTrait
{
	public function filter($column, $value): FilterableInterface
	{
		$this->addCriteria(new Equals($column, $value));

		return $this;
	}
}