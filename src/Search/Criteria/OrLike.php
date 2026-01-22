<?php

namespace Tnt\DataList\Search\Criteria;

use Tnt\Dbi\Contracts\CriteriaInterface;
use Tnt\Dbi\QueryBuilder;

class OrLike implements CriteriaInterface
{
	/**
	 * @var array<string>
	 */
	private array $columns;

	private string $value;

	/**
	 * @param array<string> $columns
	 */
	public function __construct(array $columns, string $value)
	{
		$this->columns = $columns;
		$this->value = $value;
	}

	public function apply(QueryBuilder $queryBuilder): void
	{
		$queryBuilder->whereGroup(function (QueryBuilder $queryBuilder): void {
			foreach ($this->columns as $column) {
				$queryBuilder->where($column, 'LIKE', '%' . $this->value . '%', 'OR');
			}
		}, 'AND');
	}
}
