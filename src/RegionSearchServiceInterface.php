<?php

namespace CultuurNet\UDB3\Search;

interface RegionSearchServiceInterface
{
    /**
     * @param RegionSearchParameters $searchParameters
     * @return PagedResultSet
     */
    public function search(RegionSearchParameters $searchParameters);
}
