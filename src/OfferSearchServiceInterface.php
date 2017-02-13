<?php

namespace CultuurNet\UDB3\Search;

interface OfferSearchServiceInterface
{
    /**
     * @param OfferSearchParameters $searchParameters
     * @return PagedResultSet
     */
    public function search(OfferSearchParameters $searchParameters);
}
