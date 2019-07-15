<?php

namespace Tnt\DataList\Paginate;

use Tnt\DataList\Contracts\Paginate\PaginatableInterface;

/**
 * Class SimplePaginator
 * @package Tnt\DataList\Paginate
 */
class SimplePaginator extends Paginator
{
	/**
	 * @var int $perPage
	 */
	private $perPage;

	/**
	 * @var int $currentPage
	 */
	private $currentPage;

	/**
	 * @var int $pagesCount
	 */
	private $pageCount;

	/**
	 * SimplePaginator constructor.
	 * @param int $perPage
	 */
	public function __construct(int $perPage)
	{
		$this->perPage = $perPage;
	}

	/**
	 * @param PaginatableInterface $repository
	 * @param $currentPage
	 */
	function apply(PaginatableInterface $repository, $currentPage)
	{
		$this->pageCount = ceil($this->getDataList()->getResultCount() / $this->perPage);
		$this->currentPage = ( $currentPage > 0 ? ( min( $currentPage, $this->pageCount  ) ) : $this->getDefaultPage() );
		$repository->paginate($this->currentPage, $this->perPage);
	}

	/**
	 * @return int
	 */
	public function getCurrentPage(): int
	{
		return $this->currentPage ? $this->currentPage : $this->getDefaultPage();
	}

	/**
	 * @return int
	 */
	public function getDefaultPage()
	{
		return 1;
	}

	/**
	 * @return string
	 */
	public function getNextPageUrl(): string
	{
		return $this->getDataList()->getUrlBuilder()->withParam($this->getId(), $this->getCurrentPage() + 1)->build();
	}

	/**
	 * @return string
	 */
	public function getPrevPageUrl(): string
	{
		return $this->getDataList()->getUrlBuilder()->withParam($this->getId(), $this->getCurrentPage() - 1)->build();
	}

	/**
	 * @param string $page
	 * @return string
	 */
	function getUrlForPage(string $page): string
	{
		return $this->getDataList()->getUrlBuilder()->withParam($this->getId(), $page)->build();
	}

	/**
	 * @return int
	 */
	public function getPageCount(): int
	{
		return $this->pageCount;
	}
}