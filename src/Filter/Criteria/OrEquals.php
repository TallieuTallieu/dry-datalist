<?php

namespace Tnt\DataList\Filter\Criteria;

use Tnt\Dbi\Contracts\CriteriaInterface;
use Tnt\Dbi\QueryBuilder;

class OrEquals implements CriteriaInterface
{
	/**
	 * @var mixed $column
	 */
	private $column;

	/**
	 * @var array $values
	 */
	private $values = [];

	/**
	 * OrEquals constructor.
	 * @param mixed $column
	 * @param array $values
	 */
	public function __construct($column, array $values)
	{
		$this->column = $column;
		$this->values = $values;
	}

	/**
	 * @param QueryBuilder $queryBuilder
	 */
	public function apply(QueryBuilder $queryBuilder)
	{
		$queryBuilder->whereGroup(function($queryBuilder) {
			foreach ($this->values as $value) {
				$queryBuilder->where($this->column, '=', $value, 'OR');
			}
		}, 'AND');
	}
}