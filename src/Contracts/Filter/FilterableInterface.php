<?php

namespace Tnt\DataList\Contracts\Filter;

interface FilterableInterface
{
	public function filter($column, $value): FilterableInterface;
}