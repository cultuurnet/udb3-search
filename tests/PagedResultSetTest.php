<?php

namespace CultuurNet\UDB3\Search;

use ValueObjects\Number\Natural;

class PagedResultSetTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_returns_paged_results_and_metadata()
    {
        $total = new Natural(1000);
        $perPage = new Natural(30);
        $results = [
            ['@id' => 'http://acme.com/organizer/123', 'name' => 'STUK'],
            ['@id' => 'http://acme.com/organizer/456', 'name' => 'Het Depot'],
        ];

        $pagedResultSet = new PagedResultSet(
            $total,
            $perPage,
            $results
        );

        $this->assertEquals($total, $pagedResultSet->getTotal());
        $this->assertEquals($perPage, $pagedResultSet->getPerPage());
        $this->assertEquals($results, $pagedResultSet->getResults());
    }
}
