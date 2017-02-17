<?php

namespace CultuurNet\UDB3\Search\Organizer;

use CultuurNet\UDB3\Search\PagedResultSet;

interface OrganizerSearchServiceInterface
{
    /**
     * @param OrganizerSearchParameters $searchParameters
     * @return PagedResultSet
     */
    public function search(OrganizerSearchParameters $searchParameters);
}
