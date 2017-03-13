<?php

namespace CultuurNet\UDB3\Search\Offer;

use CultuurNet\UDB3\Label\ValueObjects\LabelName;
use CultuurNet\UDB3\Search\MockQueryString;
use CultuurNet\UDB3\Search\Region\RegionId;
use ValueObjects\Number\Natural;
use ValueObjects\StringLiteral\StringLiteral;

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
    public function it_has_an_optional_query_string_parameter()
    {
        $defaultParameters = new OfferSearchParameters();

        $queryString = new MockQueryString('foo AND bar');

        $specificParameters = $defaultParameters
            ->withQueryString($queryString);

        $this->assertFalse($defaultParameters->hasQueryString());
        $this->assertNull($defaultParameters->getQueryString());

        $this->assertTrue($specificParameters->hasQueryString());
        $this->assertEquals($queryString, $specificParameters->getQueryString());
    }

    /**
     * @test
     */
    public function it_has_an_optional_region_id_parameter()
    {
        $defaultParameters = new OfferSearchParameters();

        $specificParameters = $defaultParameters
            ->withRegion(
                new RegionId('24062'),
                new StringLiteral('geoshapes'),
                new StringLiteral('region')
            );

        $this->assertEquals(new RegionId('24062'), $specificParameters->getRegionId());
        $this->assertEquals(new StringLiteral('geoshapes'), $specificParameters->getRegionIndexName());
        $this->assertEquals(new StringLiteral('region'), $specificParameters->getRegionDocumentType());
    }

    /**
     * @test
     */
    public function it_has_an_optional_label_parameter()
    {
        $defaultParameters = new OfferSearchParameters();

        $specificParameters = $defaultParameters
            ->withLabel(new LabelName('foo'))
            ->withLabels(
                ...[
                    new LabelName('bar'),
                    new LabelName('baz'),
                ]
            )
            ->withLabel(new LabelName('foobar'));

        $expected = [
            new LabelName('foo'),
            new LabelName('bar'),
            new LabelName('baz'),
            new LabelName('foobar'),
        ];

        $this->assertFalse($defaultParameters->hasLabels());
        $this->assertEmpty($defaultParameters->getLabels());

        $this->assertTrue($specificParameters->hasLabels());
        $this->assertEquals($expected, $specificParameters->getLabels());
    }
}
