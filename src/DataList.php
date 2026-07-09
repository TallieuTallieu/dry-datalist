<?php

namespace Tnt\DataList;

use Countable;
use Tnt\DataList\Contracts\DataListInterface;
use Tnt\DataList\Contracts\Filter\FilterableInterface;
use Tnt\DataList\Contracts\Input\InputInterface;
use Tnt\DataList\Contracts\Paginate\PaginatableInterface;
use Tnt\DataList\Contracts\Search\SearchableInterface;
use Tnt\DataList\Contracts\Sort\SortableInterface;
use Tnt\DataList\Contracts\Url\BuilderInterface;
use Tnt\DataList\Filter\Filter;
use Tnt\DataList\Input\GetParams;
use Tnt\DataList\Paginate\Paginator;
use Tnt\DataList\Search\Searcher;
use Tnt\DataList\Sort\Sorter;
use Tnt\Dbi\Repository;

class DataList implements DataListInterface
{
    private BuilderInterface $urlBuilder;

    private Repository $repository;

    private ?Paginator $paginator = null;

    private ?Searcher $searcher = null;

    /**
     * @var array<string, Sorter>
     */
    private array $sorters = [];

    /**
     * @var array<string, Filter>
     */
    private array $filters = [];

    private ?Sorter $defaultSorter = null;

    public function __construct(
        Repository $repository,
        BuilderInterface $urlBuilder
    ) {
        $this->repository = $repository;
        $this->urlBuilder = $urlBuilder;
    }

    public function getResults(): mixed
    {
        return $this->repository->get();
    }

    public function getResultCount(): int
    {
        $results = $this->repository->get();
        if ($results instanceof Countable || is_array($results)) {
            return count($results);
        }
        return 0;
    }

    public function setSearcher(string $id, Searcher $searcher): void
    {
        $this->registerComponent($id, $searcher);
        $this->searcher = $searcher;
    }

    public function setPaginator(string $id, Paginator $paginator): void
    {
        $this->registerComponent($id, $paginator);
        $this->paginator = $paginator;
    }

    public function addSorter(string $id, Sorter $sorter): void
    {
        $this->registerComponent($id, $sorter);
        $this->sorters[$id] = $sorter;
    }

    public function setDefaultSorter(Sorter $sorter): void
    {
        $this->defaultSorter = $sorter;
    }

    public function addFilter(string $id, Filter $filter): void
    {
        $this->registerComponent($id, $filter);
        $this->filters[$id] = $filter;
    }

    private function registerComponent(string $id, Component $component): void
    {
        $component->setId($id);
        $component->setDataList($this);
    }

    public function apply(?InputInterface $input = null): void
    {
        if ($input === null) {
            $input = new GetParams();
        }

        $repository = $this->repository;

        // Apply search
        if (
            $this->searcher !== null &&
            $repository instanceof SearchableInterface
        ) {
            $searcherId = $this->searcher->getId();
            if ($input->has($searcherId)) {
                $searchValue = $input->get($searcherId);
                if (is_string($searchValue) || is_int($searchValue)) {
                    $this->urlBuilder->setParam($searcherId, $searchValue);
                    if ($searchValue !== '' && $searchValue !== 0) {
                        $this->searcher->apply(
                            $repository,
                            (string) $searchValue
                        );
                    }
                }
            }
        }

        // Apply sorters
        $sorting = false;
        if ($repository instanceof SortableInterface) {
            foreach ($this->sorters as $sorter) {
                $sorterId = $sorter->getId();
                if ($input->has($sorterId)) {
                    $sortValue = $input->get($sorterId);
                    if (is_string($sortValue) || is_int($sortValue)) {
                        $sorting = true;
                        $this->urlBuilder->setParam($sorterId, $sortValue);
                        $sorter->apply($repository, (string) $sortValue);
                    }
                }
            }

            // Check if we need the default sorter
            if (!$sorting && $this->defaultSorter !== null) {
                $this->defaultSorter->apply($repository);
            }
        }

        // Apply filters
        if ($repository instanceof FilterableInterface) {
            foreach ($this->filters as $filter) {
                $filterId = $filter->getId();
                if ($input->has($filterId)) {
                    $filterValue = $input->get($filterId);
                    if (is_string($filterValue) || is_int($filterValue)) {
                        $this->urlBuilder->setParam($filterId, $filterValue);
                        $filter->apply($repository, $filterValue);
                    } elseif (is_array($filterValue)) {
                        /** @var array<int|string> $filterValue */
                        $this->urlBuilder->setParam($filterId, $filterValue);
                        $filter->apply($repository, $filterValue);
                    }
                }
            }
        }

        // Apply pagination
        if (
            $this->paginator !== null &&
            $repository instanceof PaginatableInterface
        ) {
            $paginatorId = $this->paginator->getId();
            if ($input->has($paginatorId)) {
                $pageValue = $input->get($paginatorId);
                if (is_numeric($pageValue)) {
                    $this->urlBuilder->setParam($paginatorId, (int) $pageValue);
                    $this->paginator->apply($repository, (int) $pageValue);
                } else {
                    $this->paginator->apply(
                        $repository,
                        $this->paginator->getDefaultPage()
                    );
                }
            } else {
                $this->paginator->apply(
                    $repository,
                    $this->paginator->getDefaultPage()
                );
            }
        }
    }

    public function getPaginator(): ?Paginator
    {
        return $this->paginator;
    }

    public function getFilter(string $id): Filter
    {
        return $this->filters[$id];
    }

    public function getSorter(string $id): Sorter
    {
        return $this->sorters[$id];
    }

    public function getUrlBuilder(): BuilderInterface
    {
        return $this->urlBuilder;
    }

    public function getRepository(): Repository
    {
        return $this->repository;
    }
}
