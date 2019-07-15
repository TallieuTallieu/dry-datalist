<?php

namespace Tnt\DataList\Search\Criteria;

use Tnt\Dbi\Contracts\CriteriaInterface;
use Tnt\Dbi\QueryBuilder;

class OrLike implements CriteriaInterface
{
	/**
	 * @var array $columns
	 */
	private $columns;

	/**
	 * @var string $value
	 */
	private $value;

	/**
	 * OrLike constructor.
	 * @param mixed $column
	 * @param $value
	 */
	public function __construct(array $columns, string $value)
	{
		$this->columns = $columns;
		$this->value = $value;
	}

	/**
	 * @param QueryBuilder $queryBuilder
	 */
	public function apply(QueryBuilder $queryBuilder)
	{
		$queryBuilder->whereGroup(function($queryBuilder) {
			foreach ($this->columns as $column) {
				$queryBuilder->where($column, 'LIKE', '%'.$this->value.'%', 'OR');
			}
		}, 'AND');
	}
}