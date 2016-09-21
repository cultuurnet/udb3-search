<?php

namespace CultuurNet\UDB3\Search;

use ValueObjects\Number\Natural;

class PagedResultSet
{
    /**
     * @var Natural
     */
    private $total;

    /**
     * @var Natural
     */
    private $perPage;

    /**
     * @var array
     */
    private $results;

    /**
     * @param Natural $total
     * @param Natural $perPage
     * @param array $results
     */
    public function __construct(
        Natural $total,
        Natural $perPage,
        array $results
    ) {
        $this->total = $total;
        $this->perPage = $perPage;
        $this->results = $results;
    }

    /**
     * @return Natural
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @return Natural
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * @return array
     */
    public function getResults()
    {
        return $this->results;
    }
}
