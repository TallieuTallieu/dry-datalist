<?php

namespace Tnt\DataList\Sort;

use Tnt\DataList\Contracts\Sort\SortableInterface;

class SimpleSorter extends Sorter
{
	/**
	 * @var mixed $columns
	 */
	private $column;

	/**
	 * LikeSearcher constructor.
	 * @param mixed $column
	 */
	public function __construct($column)
	{
		$this->column = $column;
	}

	/**
	 * @param SortableInterface $repository
	 * @param string $value
	 * @param string $sortMethod
	 */
	public function apply(SortableInterface $repository, string $sortMethod = 'ASC')
	{
		$sortMethod = strtoupper($sortMethod);

		if (! in_array($sortMethod, ['ASC', 'DESC'])) {
			$sortMethod = 'ASC';
		}

		$repository->sort($this->column, $sortMethod);
	}
}