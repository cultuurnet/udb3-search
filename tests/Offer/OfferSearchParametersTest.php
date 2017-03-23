<?php

namespace CultuurNet\UDB3\Search\Offer;

use CultuurNet\Geocoding\Coordinate\Coordinates;
use CultuurNet\Geocoding\Coordinate\Latitude;
use CultuurNet\Geocoding\Coordinate\Longitude;
use CultuurNet\UDB3\Label\ValueObjects\LabelName;
use CultuurNet\UDB3\Language;
use CultuurNet\UDB3\PriceInfo\Price;
use CultuurNet\UDB3\Search\GeoDistanceParameters;
use CultuurNet\UDB3\Search\MockDistance;
use CultuurNet\UDB3\Search\MockQueryString;
use CultuurNet\UDB3\Search\Region\RegionId;
use ValueObjects\Number\Natural;
use ValueObjects\StringLiteral\StringLiteral;

class OfferSearchParametersTest extends \PHPUnit_Framework_TestCase
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
    public function it_has_an_optional_text_languages_parameter_that_has_default_values()
    {
        $defaultParameters = new OfferSearchParameters();

        $defaultTextLanguages = [
            new Language('nl'),
            new Language('fr'),
            new Language('en'),
            new Language('de'),
        ];

        $specificTextLanguages = [
            new Language('nl'),
        ];

        $specificParameters = $defaultParameters
            ->withTextLanguages(...$specificTextLanguages);

        $this->assertEquals($defaultTextLanguages, $defaultParameters->getTextLanguages());
        $this->assertEquals($specificTextLanguages, $specificParameters->getTextLanguages());
    }

    /**
     * @test
     */
    public function it_should_use_the_default_text_languages_when_specifying_an_empty_list_of_languages()
    {
        $defaultParameters = new OfferSearchParameters();

        $defaultTextLanguages = [
            new Language('nl'),
            new Language('fr'),
            new Language('en'),
            new Language('de'),
        ];

        $specificTextLanguages = [];

        $specificParameters = $defaultParameters
            ->withTextLanguages(...$specificTextLanguages);

        $this->assertEquals($defaultTextLanguages, $specificParameters->getTextLanguages());
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
    public function it_has_an_optional_geo_distance_parameter()
    {
        $defaultParameters = new OfferSearchParameters();

        $geoDistance = new GeoDistanceParameters(
            new Coordinates(
                new Latitude(40.004567),
                new Longitude(-70.01077)
            ),
            new MockDistance('30 beard-seconds')
        );

        $specificParameters = $defaultParameters
            ->withGeoDistanceParameters($geoDistance);

        $this->assertNull($defaultParameters->getGeoDistanceParameters());
        $this->assertEquals($geoDistance, $specificParameters->getGeoDistanceParameters());
    }

    /**
     * @test
     */
    public function it_has_optional_age_range_parameters()
    {
        $defaultParameters = new OfferSearchParameters();

        $minAgeParameters = $defaultParameters
            ->withMinimumAge(new Natural(5));

        $maxAgeParameters = $defaultParameters
            ->withMaximumAge(new Natural(10));

        $rangeParameters = $defaultParameters
            ->withMinimumAge(new Natural(0))
            ->withMaximumAge(new Natural(7));

        $this->assertFalse($defaultParameters->hasAgeRange());
        $this->assertFalse($defaultParameters->hasMinimumAge());
        $this->assertFalse($defaultParameters->hasMaximumAge());
        $this->assertNull($defaultParameters->getMinimumAge());
        $this->assertNull($defaultParameters->getMaximumAge());

        $this->assertTrue($minAgeParameters->hasAgeRange());
        $this->assertTrue($minAgeParameters->hasMinimumAge());
        $this->assertFalse($minAgeParameters->hasMaximumAge());
        $this->assertEquals(new Natural(5), $minAgeParameters->getMinimumAge());
        $this->assertNull($minAgeParameters->getMaximumAge());

        $this->assertTrue($maxAgeParameters->hasAgeRange());
        $this->assertFalse($maxAgeParameters->hasMinimumAge());
        $this->assertTrue($maxAgeParameters->hasMaximumAge());
        $this->assertNull($maxAgeParameters->getMinimumAge());
        $this->assertEquals(new Natural(10), $maxAgeParameters->getMaximumAge());

        $this->assertTrue($rangeParameters->hasAgeRange());
        $this->assertTrue($rangeParameters->hasMinimumAge());
        $this->assertTrue($rangeParameters->hasMaximumAge());
        $this->assertEquals(new Natural(0), $rangeParameters->getMinimumAge());
        $this->assertEquals(new Natural(7), $rangeParameters->getMaximumAge());
    }

    /**
     * @test
     */
    public function it_throws_invalid_argument_exception_when_minimum_age_is_not_smaller_then_maximum_age()
    {
        $defaultParameters = new OfferSearchParameters();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Minimum age should be smaller or equal to maximum age.');

        $defaultParameters
            ->withMinimumAge(new Natural(10))
            ->withMaximumAge(new Natural(5));
    }

    /**
     * @test
     */
    public function it_has_an_optional_price()
    {
        $defaultParameters = new OfferSearchParameters();

        $specificParameters = $defaultParameters->withPrice(Price::fromFloat(1.55));

        $this->assertNull($defaultParameters->getPrice());
        $this->assertFalse($defaultParameters->hasPrice());

        $this->assertEquals(
            Price::fromFloat(1.55),
            $specificParameters->getPrice()
        );
        $this->assertTrue($specificParameters->hasPrice());
    }

    /**
     * @test
     */
    public function it_has_optional_price_range_parameters()
    {
        $defaultParameters = new OfferSearchParameters();

        $minPriceParameters = $defaultParameters
            ->withMinimumPrice(Price::fromFloat(9.99));

        $maxPriceParameters = $defaultParameters
            ->withMaximumPrice(Price::fromFloat(19.99));

        $rangeParameters = $defaultParameters
            ->withMinimumPrice(Price::fromFloat(9.99))
            ->withMaximumPrice(Price::fromFloat(19.99));

        $this->assertFalse($defaultParameters->hasPriceRange());
        $this->assertFalse($defaultParameters->hasMinimumPrice());
        $this->assertFalse($defaultParameters->hasMaximumPrice());
        $this->assertNull($defaultParameters->getMinimumPrice());
        $this->assertNull($defaultParameters->getMaximumPrice());

        $this->assertTrue($minPriceParameters->hasPriceRange());
        $this->assertTrue($minPriceParameters->hasMinimumPrice());
        $this->assertFalse($minPriceParameters->hasMaximumPrice());
        $this->assertEquals(Price::fromFloat(9.99), $minPriceParameters->getMinimumPrice());
        $this->assertNull($minPriceParameters->getMaximumPrice());

        $this->assertTrue($maxPriceParameters->hasPriceRange());
        $this->assertFalse($maxPriceParameters->hasMinimumPrice());
        $this->assertTrue($maxPriceParameters->hasMaximumPrice());
        $this->assertNull($maxPriceParameters->getMinimumPrice());
        $this->assertEquals(Price::fromFloat(19.99), $maxPriceParameters->getMaximumPrice());

        $this->assertTrue($rangeParameters->hasPriceRange());
        $this->assertTrue($rangeParameters->hasMinimumPrice());
        $this->assertTrue($rangeParameters->hasMaximumPrice());
        $this->assertEquals(Price::fromFloat(9.99), $rangeParameters->getMinimumPrice());
        $this->assertEquals(Price::fromFloat(19.99), $rangeParameters->getMaximumPrice());
    }

    /**
     * @test
     */
    public function it_has_an_optional_labels_parameter()
    {
        $defaultParameters = new OfferSearchParameters();

        $specificParameters = $defaultParameters
            ->withLabels(new LabelName('foo'))
            ->withLabels(
                ...[
                    new LabelName('bar'),
                    new LabelName('baz'),
                ]
            )
            ->withLabels(new LabelName('foobar'));

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

    /**
     * @test
     */
    public function it_has_an_optional_location_labels_parameter()
    {
        $defaultParameters = new OfferSearchParameters();

        $specificParameters = $defaultParameters
            ->withLocationLabels(new LabelName('foo'))
            ->withLocationLabels(
                ...[
                    new LabelName('bar'),
                    new LabelName('baz'),
                ]
            )
            ->withLocationLabels(new LabelName('foobar'));

        $expected = [
            new LabelName('foo'),
            new LabelName('bar'),
            new LabelName('baz'),
            new LabelName('foobar'),
        ];

        $this->assertFalse($defaultParameters->hasLocationLabels());
        $this->assertEmpty($defaultParameters->getLocationLabels());

        $this->assertTrue($specificParameters->hasLocationLabels());
        $this->assertEquals($expected, $specificParameters->getLocationLabels());

        $this->assertFalse($specificParameters->hasLabels());
    }

    /**
     * @test
     */
    public function it_has_an_optional_organizer_labels_parameter()
    {
        $defaultParameters = new OfferSearchParameters();

        $specificParameters = $defaultParameters
            ->withOrganizerLabels(new LabelName('foo'))
            ->withOrganizerLabels(
                ...[
                    new LabelName('bar'),
                    new LabelName('baz'),
                ]
            )
            ->withOrganizerLabels(new LabelName('foobar'));

        $expected = [
            new LabelName('foo'),
            new LabelName('bar'),
            new LabelName('baz'),
            new LabelName('foobar'),
        ];

        $this->assertFalse($defaultParameters->hasOrganizerLabels());
        $this->assertEmpty($defaultParameters->getOrganizerLabels());

        $this->assertTrue($specificParameters->hasOrganizerLabels());
        $this->assertEquals($expected, $specificParameters->getOrganizerLabels());

        $this->assertFalse($specificParameters->hasLabels());
    }
}
