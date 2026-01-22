<?php

namespace Tnt\DataList\Search;

use Tnt\DataList\Contracts\Search\SearchableInterface;

class LikeSearcher extends Searcher
{
	/**
	 * @var array<string>
	 */
	private array $columns;

	/**
	 * @param array<string> $columns
	 */
	public function __construct(array $columns)
	{
		$this->columns = $columns;
	}

	public function apply(SearchableInterface $repository, string $value): void
	{
		$repository->search($this->columns, $value);
	}
}
