<?php

namespace Tnt\DataList\Sort;

use Tnt\DataList\Contracts\Sort\SortableInterface;

class ColumnSorter extends Sorter
{
    protected $defaultSortString;
    protected $separator;
    
	/**
	 * ColumnSorter contstruct
     * See encatc sort-select.twig for implementation
     * @param string $defaultSortString string containing column and direction
     * @param string $separator string to separate column and direction
	 */
	public function __construct($defaultSortString = '', $separator = '-')
	{
        $this->defaultSortString = strtoupper($defaultSortString);
        $this->separator = $separator;
	}

	/**
	 * @param SortableInterface $repository
	 * @param string $sortMethod
	 */
	public function apply(SortableInterface $repository, string $sortString = '')
	{
        if (empty($sortString)) {
            $sortString = $this->defaultSortString;
        }

        $sortDefinition = explode($this->separator, $sortString);

        if (!count($sortDefinition) === 2) {
            return;
        }

        $sortColumn = $sortDefinition[0];
        $sortDirection = strtoupper($sortDefinition[1]);

		if (! in_array($sortDirection, ['ASC', 'DESC'])) {
            return;
		}


		$repository->sort($sortColumn, $sortDirection);
	}
}
