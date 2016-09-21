<?php

namespace CultuurNet\UDB3\Search;

use ValueObjects\Number\Natural;

interface OrganizerSearchServiceInterface
{
    /**
     * @param OrganizerSearchParameters $searchParameters
     * @return PagedResultSet
     */
    public function search(OrganizerSearchParameters $searchParameters);

    /**
     * @param Natural $maxResultsPerPage
     * @return self
     */
    public function withMaxResultsPerPage(Natural $maxResultsPerPage);
}
