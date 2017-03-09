<?php

namespace CultuurNet\UDB3\Search\Offer;

use CultuurNet\UDB3\Search\PagedResultSet;

interface OfferSearchServiceInterface
{
    /**
     * @param OfferSearchParameters $searchParameters
     * @return PagedResultSet
     */
    public function search(OfferSearchParameters $searchParameters);
}
