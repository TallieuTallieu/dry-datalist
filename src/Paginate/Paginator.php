<?php

namespace Tnt\DataList\Paginate;

use Tnt\DataList\Component;
use Tnt\DataList\Contracts\Paginate\PaginatableInterface;

abstract class Paginator extends Component
{
    abstract public function apply(PaginatableInterface $repository, ?int $currentPage): void;
    abstract public function getCurrentPage(): int;
    abstract public function getDefaultPage(): ?int;
    abstract public function getNextPageUrl(): string;
    abstract public function getPrevPageUrl(): string;
    abstract public function getUrlForPage(string $page): string;
    abstract public function getPageCount(): int;
}
