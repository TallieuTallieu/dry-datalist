<?php

namespace Tnt\DataList\Search;

use Tnt\DataList\Contracts\Search\SearchableInterface;
use Tnt\DataList\Search\Criteria\OrLike;

trait SearchableTrait
{
    /**
     * @param array<string> $columns
     */
    public function search(array $columns, string $value): SearchableInterface
    {
        $this->addCriteria(new OrLike($columns, $value));

        /** @var SearchableInterface $this */
        return $this;
    }
}
