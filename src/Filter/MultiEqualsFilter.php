<?php

namespace Tnt\DataList\Filter;

use Tnt\DataList\Contracts\Filter\FilterableInterface;

class MultiEqualsFilter extends Filter
{
	/**
	 * @var mixed $columns
	 */
	private $column;

	/**
	 * EqualsFilter constructor.
	 * @param $column
	 */
	public function __construct($column)
	{
		$this->column = $column;
	}

	/**
	 * @param FilterableInterface $repository
	 * @param $value
	 */
	function apply(FilterableInterface $repository, $value)
	{
		$values = explode('-', $value);

		$repository->filter($this->column, $values);
	}
}