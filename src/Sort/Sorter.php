<?php

namespace Tnt\DataList\Sort;

use Tnt\DataList\Component;
use Tnt\DataList\Contracts\Sort\SortableInterface;

abstract class Sorter extends Component
{
	abstract function apply(SortableInterface $repository, string $sortMethod = 'ASC');
}