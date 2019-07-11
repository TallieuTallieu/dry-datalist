<?php

namespace Tnt\DataList\Search;

use Tnt\DataList\Contracts\Search\SearchableInterface;

class LikeSearcher extends Searcher
{
	/**
	 * @var array $columns
	 */
	private $columns;

	/**
	 * LikeSearcher constructor.
	 * @param array $columns
	 */
	public function __construct(array $columns)
	{
		$this->columns = $columns;
	}

	/**
	 * @param SearchableInterface $repository
	 * @param string $value
	 */
	public function apply(SearchableInterface $repository, string $value)
	{
		$repository->search($this->columns, $value);
	}
}