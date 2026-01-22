<?php

namespace Tnt\DataList\Filter\Criteria;

use Tnt\Dbi\Contracts\CriteriaInterface;
use Tnt\Dbi\QueryBuilder;

class OrEquals implements CriteriaInterface
{
	private string $column;

	/**
	 * @var array<int|string>
	 */
	private array $values;

	/**
	 * @param array<int|string> $values
	 */
	public function __construct(string $column, array $values)
	{
		$this->column = $column;
		$this->values = $values;
	}

	public function apply(QueryBuilder $queryBuilder): void
	{
		$queryBuilder->whereGroup(function (QueryBuilder $queryBuilder): void {
			foreach ($this->values as $value) {
				$queryBuilder->where($this->column, '=', $value, 'OR');
			}
		}, 'AND');
	}
}
