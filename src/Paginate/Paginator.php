<?php

namespace Tnt\DataList\Paginate;

use Tnt\DataList\Component;
use Tnt\DataList\Contracts\Paginate\PaginatableInterface;

abstract class Paginator extends Component
{
    abstract function apply(PaginatableInterface $repository, $currentPage);
    abstract function getCurrentPage();
    abstract function getDefaultPage();
    abstract function getNextPageUrl(): string;
    abstract function getPrevPageUrl(): string;
    abstract function getUrlForPage(string $page): string;
    abstract function getPageCount();
}