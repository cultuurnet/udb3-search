<?php

namespace CultuurNet\UDB3\Search\Offer;

use CultuurNet\UDB3\Search\Region\RegionId;
use ValueObjects\Number\Natural;

class OfferFilterParametersTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_has_configurable_start_and_limit_parameters_with_default_values()
    {
        $defaultParameters = new OfferSearchParameters();

        $specificParameters = $defaultParameters
            ->withStart(new Natural(20))
            ->withLimit(new Natural(10));

        $this->assertEquals(new Natural(0), $defaultParameters->getStart());
        $this->assertEquals(new Natural(30), $defaultParameters->getLimit());

        $this->assertEquals(new Natural(20), $specificParameters->getStart());
        $this->assertEquals(new Natural(10), $specificParameters->getLimit());
    }

    /**
     * @test
     */
    public function it_has_an_optional_region_id_parameter()
    {
        $defaultParameters = new OfferSearchParameters();

        $specificParameters = $defaultParameters
            ->withRegionId(new RegionId('24062'));

        $this->assertEquals(new RegionId('24062'), $specificParameters->getRegionId());
    }
}
