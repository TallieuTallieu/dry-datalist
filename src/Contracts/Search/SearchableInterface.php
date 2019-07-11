<?php

namespace Tnt\DataList\Contracts\Search;

interface SearchableInterface
{
	public function search(array $columns, string $value): SearchableInterface;
}