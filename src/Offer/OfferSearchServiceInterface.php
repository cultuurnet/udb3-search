<?php

namespace CultuurNet\UDB3\Search\Offer;

use CultuurNet\UDB3\Search\PagedResultSet;

interface OfferSearchServiceInterface
{
    /**
     * @param OfferFilterParameters $filterParameters
     * @return PagedResultSet
     */
    public function filter(OfferFilterParameters $filterParameters);
}
