<?php

namespace Tnt\DataList\Filter;

use Tnt\DataList\Contracts\Filter\FilterableInterface;

class EqualsFilter extends Filter
{
	private string $column;

	public function __construct(string $column)
	{
		$this->column = $column;
	}

	public function apply(FilterableInterface $repository, mixed $value): void
	{
		if (is_string($value) || is_int($value)) {
			$repository->filter($this->column, [(string) $value]);
		}
	}
}
