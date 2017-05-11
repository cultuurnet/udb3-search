<?php

namespace CultuurNet\UDB3\Search\Offer;

use CultuurNet\UDB3\Search\SortOrder;

class Sorting
{
    /**
     * @var SortBy
     */
    private $sortBy;

    /**
     * @var SortOrder
     */
    private $sortOrder;

    /**
     * @param SortBy $sortBy
     * @param SortOrder $order
     */
    public function __construct(SortBy $sortBy, SortOrder $order)
    {
        $this->sortBy = $sortBy;
        $this->sortOrder = $order;
    }

    /**
     * @return SortBy
     */
    public function getSortBy()
    {
        return $this->sortBy;
    }

    /**
     * @return SortOrder
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }
}
