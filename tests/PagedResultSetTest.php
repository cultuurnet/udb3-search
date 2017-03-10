<?php

namespace CultuurNet\UDB3\Search;

use CultuurNet\UDB3\ReadModel\JsonDocument;
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
            (new JsonDocument(123))
                ->withBody(
                    (object) ['@id' => 'http://acme.com/organizer/123', 'name' => 'STUK']
                ),
            (new JsonDocument(456))
                ->withBody(
                    (object) ['@id' => 'http://acme.com/organizer/456', 'name' => 'Het Depot']
                ),
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

    /**
     * @test
     */
    public function it_guards_that_results_are_all_json_documents()
    {
        $total = new Natural(1000);
        $perPage = new Natural(30);

        $results = [
            (new JsonDocument(123))
                ->withBody(
                    (object) ['@id' => 'http://acme.com/organizer/123', 'name' => 'STUK']
                ),
            'foo',
            'bar',
        ];

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Results should be an array of JsonDocument objects.');

        new PagedResultSet(
            $total,
            $perPage,
            $results
        );
    }
}
