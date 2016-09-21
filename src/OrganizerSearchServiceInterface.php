<?php

namespace CultuurNet\UDB3\Search;

interface OrganizerSearchServiceInterface
{
    /**
     * @param OrganizerSearchParameters $searchParameters
     * @return PagedResultSet
     */
    public function search(OrganizerSearchParameters $searchParameters);
}
