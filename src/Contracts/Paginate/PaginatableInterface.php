<?php

namespace Tnt\DataList\Contracts\Paginate;

interface PaginatableInterface
{
	public function paginate(int $currentPage = 1, int $perPage = 30): PaginatableInterface;
}