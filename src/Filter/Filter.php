<?php

namespace Tnt\DataList\Filter;

use Tnt\DataList\Component;
use Tnt\DataList\Contracts\Filter\FilterableInterface;

abstract class Filter extends Component
{
	abstract function apply(FilterableInterface $repository, $value);
}