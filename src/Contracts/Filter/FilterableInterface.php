<?php

namespace Tnt\DataList\Contracts\Filter;

interface FilterableInterface
{
	/**
	 * @param array<int|string> $values
	 */
	public function filter(string $column, array $values): FilterableInterface;
}
