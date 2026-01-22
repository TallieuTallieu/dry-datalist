<?php

namespace Tnt\DataList\Contracts\Search;

interface SearchableInterface
{
	/**
	 * @param array<string> $columns
	 */
	public function search(array $columns, string $value): SearchableInterface;
}
