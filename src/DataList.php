<?php

namespace Tnt\DataList;

use dry\db\ResultSet;
use Tnt\DataList\Contracts\DataListInterface;
use Tnt\DataList\Contracts\Input\InputInterface;
use Tnt\DataList\Contracts\Url\BuilderInterface;
use Tnt\DataList\Filter\Filter;
use Tnt\DataList\Paginate\Paginator;
use Tnt\DataList\Search\Searcher;
use Tnt\DataList\Sort\Sorter;
use Tnt\Dbi\Repository;

class DataList implements DataListInterface
{
    /**
     * @var BuilderInterface $urlBuilder
     */
    private $urlBuilder;

    /**
     * @var Repository $repository
     */
    private $repository;

    /**
     * @var Paginator $paginator
     */
    private $paginator;

    /**
     * @var Searcher $searcher
     */
    private $searcher;

    /**
     * @var array $sorters
     */
    private $sorters = [];

    /**
     * @var array $filters
     */
    private $filters = [];

    /**
     * @var Sorter $defaultSorter
     */
    private $defaultSorter;

    /**
     * DataList constructor.
     * @param Repository $repository
     * @param BuilderInterface $urlBuilder
     */
    public function __construct(Repository $repository, BuilderInterface $urlBuilder)
    {
        $this->repository = $repository;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * @return ResultSet
     */
    public function getResults(): ResultSet
    {
        return $this->repository->get();
    }

    /**
     * @return int
     */
    public function getResultCount(): int
    {
        return count($this->repository->get());
    }

    /**
     * @param string $id
     * @param Searcher $searcher
     */
    public function setSearcher(string $id, Searcher $searcher)
    {
        $this->registerComponent($id, $searcher);
        $this->searcher = $searcher;
    }

    /**
     * @param string $id
     * @param Paginator $paginator
     */
    public function setPaginator(string $id, Paginator $paginator)
    {
        $this->registerComponent($id, $paginator);
        $this->paginator = $paginator;
    }

    /**
     * @param string $id
     * @param Sorter $sorter
     */
    public function addSorter(string $id, Sorter $sorter)
    {
        $this->registerComponent($id, $sorter);
        $this->sorters[$id] = $sorter;
    }

    /**
     * @param Sorter $sorter
     */
    public function setDefaultSorter(Sorter $sorter)
    {
        $this->defaultSorter = $sorter;
    }

    /**
     * @param string $id
     * @param Filter $filter
     */
    public function addFilter(string $id, Filter $filter)
    {
        $this->registerComponent($id, $filter);
        $this->filters[$id] = $filter;
    }

    /**
     * @param string $id
     * @param Component $component
     */
    private function registerComponent(string $id, Component $component)
    {
        $component->setId($id);
        $component->setDataList($this);
    }

    /**
     * @param InputInterface $input
     */
    public function apply(InputInterface $input)
    {
        // Apply search
        if ($this->searcher) {
            if ($input->has($this->searcher->getId()) && $input->get($this->searcher->getId())) {
                $this->urlBuilder->setParam($this->searcher->getId(), $input->get($this->searcher->getId()));
                $this->searcher->apply($this->repository, $input->get($this->searcher->getId()));
            }
        }

        // Apply sorters
        $sorting = false;
        foreach ($this->sorters as $sorter) {
            if ($input->has($sorter->getId()) && $input->get($sorter->getId())) {
                $sorting = true;
                $this->urlBuilder->setParam($sorter->getId(), $input->get($sorter->getId()));
                $sorter->apply($this->repository, $input->get($sorter->getId()));
            }
        }

        // Check if we need the default sorter
        if (! $sorting && $this->defaultSorter) {
            $this->defaultSorter->apply($this->repository);
        }

        // Apply filters
        foreach ($this->filters as $filter) {
            if ($input->has($filter->getId())) {
                $this->urlBuilder->setParam($filter->getId(), $input->get($filter->getId()));
                $filter->apply($this->repository, $input->get($filter->getId()));
            }
        }

        // Apply pagination
        if ($this->paginator) {
            if ($input->has($this->paginator->getId()) && $input->get($this->paginator->getId())) {
                $this->urlBuilder->setParam($this->paginator->getId(), $input->get($this->paginator->getId()));
                $this->paginator->apply($this->repository, $input->get($this->paginator->getId()));
            } else {
                $this->paginator->apply($this->repository, $this->paginator->getDefaultPage());
            }
        }
    }

    /**
     * @return Paginator
     */
    public function getPaginator(): Paginator
    {
        return $this->paginator;
    }

    /**
     * @param string $id
     * @return Filter
     */
    public function getFilter(string $id): Filter
    {
        return $this->filters[$id];
    }

    /**
     * @param string $id
     * @return Sorter
     */
    public function getSorter(string $id): Sorter
    {
        return $this->sorters[$id];
    }

    /**
     * @return BuilderInterface
     */
    public function getUrlBuilder(): BuilderInterface
    {
        return $this->urlBuilder;
    }
}