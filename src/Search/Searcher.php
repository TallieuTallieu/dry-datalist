<?php

namespace Tnt\DataList\Search;

use Tnt\DataList\Component;
use Tnt\DataList\Contracts\Search\SearchableInterface;

abstract class Searcher extends Component
{
	abstract function apply(SearchableInterface $repository, string $value);
}