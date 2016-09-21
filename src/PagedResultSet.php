<?php

namespace CultuurNet\UDB3\Search;

use CultuurNet\UDB3\ReadModel\JsonDocument;
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
     * @param JsonDocument[] $results
     */
    public function __construct(
        Natural $total,
        Natural $perPage,
        array $results
    ) {
        $this->guardResults($results);

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

    /**
     * @param array $results
     */
    private function guardResults(array $results)
    {
        foreach ($results as $result) {
            if (!($result instanceof JsonDocument)) {
                throw new \InvalidArgumentException('Results should be an array of JsonDocument objects.');
            }
        }
    }
}
