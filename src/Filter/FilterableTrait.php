<?php

namespace Tnt\DataList\Filter;

use Tnt\DataList\Contracts\Filter\FilterableInterface;
use Tnt\DataList\Filter\Criteria\OrEquals;

trait FilterableTrait
{
	/**
	 * @param array<int|string> $values
	 */
	public function filter(string $column, array $values): FilterableInterface
	{
		$this->addCriteria(new OrEquals($column, $values));

		/** @var FilterableInterface $this */
		return $this;
	}
}
