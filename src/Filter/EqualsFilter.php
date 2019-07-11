<?php

namespace Tnt\DataList\Filter;

use Tnt\DataList\Contracts\Filter\FilterableInterface;

class EqualsFilter extends Filter
{
	/**
	 * @var mixed $column
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
		$repository->filter($this->column, $value);
	}
}