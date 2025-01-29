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
     * @var string $defaultSortMethod
     */
    private $defaultSortMethod;

	/**
	 * LikeSearcher constructor.
	 * @param mixed $column
	 */
	public function __construct($column, $defaultSortMethod = 'ASC')
	{
		$this->column = $column;

        $this->defaultSortMethod = strtoupper($defaultSortMethod);
	}

	/**
	 * @param SortableInterface $repository
	 * @param string $value
	 * @param string $sortMethod
	 */
	public function apply(SortableInterface $repository, string $sortMethod = '')
	{
		$sortMethod = strtoupper($sortMethod);

		if (! in_array($sortMethod, ['ASC', 'DESC'])) {
			$sortMethod = $this->defaultSortMethod;
		}

		$repository->sort($this->column, $sortMethod);
	}
}
