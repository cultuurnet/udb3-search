<?php

namespace CultuurNet\UDB3\Search\Offer;

use CultuurNet\UDB3\Search\SortOrder;

class SortingTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Sorting
     */
    private $sorting;

    protected function setUp()
    {
        $this->sorting = new Sorting(
            SortBy::AVAILABLE_TO(),
            SortOrder::ASC()
        );
    }

    /**
     * @test
     */
    public function it_stores_a_sort_by()
    {
        $this->assertEquals(
            SortBy::AVAILABLE_TO(),
            $this->sorting->getSortBy()
        );
    }

    /**
     * @test
     */
    public function it_stores_a_sort_order()
    {
        $this->assertEquals(
            SortOrder::ASC(),
            $this->sorting->getSortOrder()
        );
    }
}
