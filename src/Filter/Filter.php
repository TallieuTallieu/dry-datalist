<?php

namespace Tnt\DataList\Filter;

use Tnt\DataList\Component;
use Tnt\DataList\Contracts\Filter\FilterableInterface;

abstract class Filter extends Component
{
    abstract public function apply(
        FilterableInterface $repository,
        mixed $value
    ): void;
}
