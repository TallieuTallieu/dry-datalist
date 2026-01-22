<?php

namespace Tnt\DataList\Paginate;

use Tnt\DataList\Contracts\Paginate\PaginatableInterface;

class SimplePaginator extends Paginator
{
    private int $perPage;

    private bool $optional;

    private int $currentPage = 1;

    private int $pageCount = 1;

    public function __construct(int $perPage, bool $optional = false)
    {
        $this->perPage = $perPage;
        $this->optional = $optional;
    }

    public function apply(PaginatableInterface $repository, ?int $currentPage): void
    {
        if ($currentPage !== null) {
            $resultCount = $this->getDataList()->getResultCount();
            $this->pageCount = $resultCount === 0 ? 1 : (int) ceil($resultCount / $this->perPage);
            $this->currentPage = $currentPage > 0 ? min($currentPage, $this->pageCount) : ($this->getDefaultPage() ?? 1);
            $repository->paginate($this->currentPage, $this->perPage);
        }
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage ?: ($this->getDefaultPage() ?? 1);
    }

    public function getDefaultPage(): ?int
    {
        return $this->optional ? null : 1;
    }

    public function getNextPageUrl(): string
    {
        return $this->getDataList()->getUrlBuilder()->withParam($this->getId(), $this->getCurrentPage() + 1)->build();
    }

    public function getPrevPageUrl(): string
    {
        return $this->getDataList()->getUrlBuilder()->withParam($this->getId(), $this->getCurrentPage() - 1)->build();
    }

    public function getUrlForPage(string $page): string
    {
        return $this->getDataList()->getUrlBuilder()->withParam($this->getId(), $page)->build();
    }

    public function getPageCount(): int
    {
        return $this->pageCount;
    }
}
