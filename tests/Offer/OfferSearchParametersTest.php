<?php

namespace CultuurNet\UDB3\Search\Offer;

use CultuurNet\Geocoding\Coordinate\Coordinates;
use CultuurNet\Geocoding\Coordinate\Latitude;
use CultuurNet\Geocoding\Coordinate\Longitude;
use CultuurNet\UDB3\Address\PostalCode;
use CultuurNet\UDB3\Label\ValueObjects\LabelName;
use CultuurNet\UDB3\Language;
use CultuurNet\UDB3\PriceInfo\Price;
use CultuurNet\UDB3\Search\GeoDistanceParameters;
use CultuurNet\UDB3\Search\MockDistance;
use CultuurNet\UDB3\Search\MockQueryString;
use CultuurNet\UDB3\Search\Region\RegionId;
use ValueObjects\Geography\Country;
use ValueObjects\Geography\CountryCode;
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
    public function it_has_an_optional_cdbid_parameter()
    {
        $defaultParameters = new OfferSearchParameters();

        $specificParameters = $defaultParameters
            ->withCdbid(
                new Cdbid('663bf2af-f49f-40f9-8253-363facdf4474')
            );

        $this->assertFalse($defaultParameters->hasCdbid());
        $this->assertNull($defaultParameters->getCdbid());

        $this->assertTrue($specificParameters->hasCdbid());
        $this->assertEquals(
            new Cdbid('663bf2af-f49f-40f9-8253-363facdf4474'),
            $specificParameters->getCdbid()
        );
    }

    /**
     * @test
     */
    public function it_has_an_optional_location_cdbid_parameter()
    {
        $defaultParameters = new OfferSearchParameters();

        $specificParameters = $defaultParameters
            ->withLocationCdbid(
                new Cdbid('a0fe3ec9-a70c-4879-ac32-80a85b2c83c2')
            );

        $this->assertFalse($defaultParameters->hasLocationCdbid());
        $this->assertNull($defaultParameters->getLocationCdbid());

        $this->assertTrue($specificParameters->hasLocationCdbid());
        $this->assertEquals(
            new Cdbid('a0fe3ec9-a70c-4879-ac32-80a85b2c83c2'),
            $specificParameters->getLocationCdbid()
        );
    }

    /**
     * @test
     */
    public function it_has_an_optional_organizer_cdbid_parameter()
    {
        $defaultParameters = new OfferSearchParameters();

        $specificParameters = $defaultParameters
            ->withOrganizerCdbid(
                new Cdbid('6554633c-803a-4080-8137-4f6a60f88c0a')
            );

        $this->assertFalse($defaultParameters->hasOrganizerCdbid());
        $this->assertNull($defaultParameters->getOrganizerCdbid());

        $this->assertTrue($specificParameters->hasOrganizerCdbid());
        $this->assertEquals(
            new Cdbid('6554633c-803a-4080-8137-4f6a60f88c0a'),
            $specificParameters->getOrganizerCdbid()
        );
    }

    /**
     * @test
     */
    public function it_has_an_optional_available_from_parameter()
    {
        $defaultParameters = new OfferSearchParameters();

        $availableFrom = \DateTimeImmutable::createFromFormat('Y-m-d', '2017-04-25');

        $specificParameters = $defaultParameters
            ->withAvailableFrom($availableFrom);

        $this->assertFalse($defaultParameters->hasAvailableFrom());
        $this->assertNull($defaultParameters->getAvailableFrom());

        $this->assertTrue($specificParameters->hasAvailableFrom());
        $this->assertEquals($availableFrom, $specificParameters->getAvailableFrom());
    }

    /**
     * @test
     */
    public function it_has_an_optional_available_to_parameter()
    {
        $defaultParameters = new OfferSearchParameters();

        $availableTo = \DateTimeImmutable::createFromFormat('Y-m-d', '2017-04-25');

        $specificParameters = $defaultParameters
            ->withAvailableTo($availableTo);

        $this->assertFalse($defaultParameters->hasAvailableTo());
        $this->assertNull($defaultParameters->getAvailableTo());

        $this->assertTrue($specificParameters->hasAvailableTo());
        $this->assertEquals($availableTo, $specificParameters->getAvailableTo());
    }

    /**
     * @test
     */
    public function it_makes_sure_available_from_is_always_lte_than_available_to()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('availableFrom should be equal to or smaller than availableTo.');

        (new OfferSearchParameters())
            ->withAvailableTo(\DateTimeImmutable::createFromFormat('Y-m-d', '2017-04-25'))
            ->withAvailableFrom(\DateTimeImmutable::createFromFormat('Y-m-d', '2017-04-26'));
    }

    /**
     * @test
     */
    public function it_makes_sure_available_to_is_always_gte_than_available_from()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('availableFrom should be equal to or smaller than availableTo.');

        (new OfferSearchParameters())
            ->withAvailableFrom(\DateTimeImmutable::createFromFormat('Y-m-d', '2017-04-26'))
            ->withAvailableTo(\DateTimeImmutable::createFromFormat('Y-m-d', '2017-04-25'));
    }

    /**
     * @test
     */
    public function it_has_an_optional_workflow_status_parameter()
    {
        $defaultParameters = new OfferSearchParameters();

        $specificParameters = $defaultParameters
            ->withWorkflowStatus(
                new WorkflowStatus('DRAFT')
            );

        $this->assertFalse($defaultParameters->hasWorkflowStatus());
        $this->assertNull($defaultParameters->getWorkflowStatus());

        $this->assertTrue($specificParameters->hasWorkflowStatus());
        $this->assertEquals(new WorkflowStatus('DRAFT'), $specificParameters->getWorkflowStatus());
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

        $this->assertFalse($defaultParameters->hasGeoDistanceParameters());
        $this->assertNull($defaultParameters->getGeoDistanceParameters());

        $this->assertTrue($specificParameters->hasGeoDistanceParameters());
        $this->assertEquals($geoDistance, $specificParameters->getGeoDistanceParameters());
    }

    /**
     * @test
     */
    public function it_has_an_optional_postal_code_parameter()
    {
        $defaultParameters = new OfferSearchParameters();

        $specificParameters = $defaultParameters
            ->withPostalCode(new PostalCode('3000'));

        $this->assertFalse($defaultParameters->hasPostalCode());
        $this->assertNull($defaultParameters->getPostalCode());

        $this->assertTrue($specificParameters->hasPostalCode());
        $this->assertEquals(new PostalCode('3000'), $specificParameters->getPostalCode());
    }

    /**
     * @test
     */
    public function it_has_an_optional_address_country_parameter()
    {
        $defaultParameters = new OfferSearchParameters();

        $nl = new Country(
            CountryCode::fromNative('NL')
        );

        $specificParameters = $defaultParameters
            ->withAddressCountry($nl);

        $this->assertFalse($defaultParameters->hasAddressCountry());
        $this->assertNull($defaultParameters->getAddressCountry());

        $this->assertTrue($specificParameters->hasAddressCountry());
        $this->assertEquals($nl, $specificParameters->getAddressCountry());
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
    public function it_throws_invalid_argument_exception_when_minimum_price_is_not_smaller_then_maximum_price()
    {
        $defaultParameters = new OfferSearchParameters();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Minimum price should be smaller or equal to maximum price.');

        $defaultParameters
            ->withMinimumPrice(Price::fromFloat(9.99))
            ->withMaximumPrice(Price::fromFloat(9.95));
    }

    /**
     * @test
     */
    public function it_has_an_optional_audience_type_paramater()
    {
        $defaultParameters = new OfferSearchParameters();

        $specificParameters = $defaultParameters
            ->withAudienceType(new AudienceType('members'));

        $this->assertFalse($defaultParameters->hasAudienceType());
        $this->assertNull($defaultParameters->getAudienceType());

        $this->assertTrue($specificParameters->hasAudienceType());
        $this->assertEquals(
            new AudienceType('members'),
            $specificParameters->getAudienceType()
        );
    }

    /**
     * @test
     */
    public function it_has_an_optional_media_objects_filter_parameter()
    {
        $shouldHaveMediaObjects = true;

        $defaultParameters = new OfferSearchParameters();

        $specificParameters = $defaultParameters
            ->withMediaObjectsToggle($shouldHaveMediaObjects);

        $this->assertFalse($defaultParameters->hasMediaObjectsToggle());
        $this->assertNull($defaultParameters->getMediaObjectsToggle());

        $this->assertTrue($specificParameters->hasMediaObjectsToggle());
        $this->assertEquals($shouldHaveMediaObjects, $specificParameters->getMediaObjectsToggle());
    }

    /**
     * @test
     * @dataProvider mediaObjectsDataProvider
     * @param mixed $shouldHaveMediaObjects
     * @param bool $expectedShouldHaveMediaObjects
     */
    public function it_converts_media_objects_filter_parameter_to_boolean(
        $shouldHaveMediaObjects,
        $expectedShouldHaveMediaObjects
    ) {
        $specificParameters = (new OfferSearchParameters())
            ->withMediaObjectsToggle($shouldHaveMediaObjects);

        $this->assertTrue($specificParameters->hasMediaObjectsToggle());

        $this->assertEquals(
            $expectedShouldHaveMediaObjects,
            $specificParameters->getMediaObjectsToggle()
        );
    }

    /**
     * @return array
     */
    public function mediaObjectsDataProvider()
    {
        return [
            [
                true,
                true,
            ],
            [
                false,
                false,
            ],
            [
                '1',
                true,
            ],
            [
                '0',
                false,
            ],
            [
                'TRue',
                true,
            ],
            [
                'faLSE',
                false,
            ]
        ];
    }

    /**
     * @test
     */
    public function it_has_an_optional_date_from_parameter()
    {
        $dateFrom = \DateTimeImmutable::createFromFormat(\DateTime::ATOM, '2017-04-28T15:26:12+00:00');

        $defaultParameters = new OfferSearchParameters();

        $specificParameters = $defaultParameters
            ->withDateFrom($dateFrom);

        $this->assertFalse($defaultParameters->hasDateFrom());
        $this->assertNull($defaultParameters->getDateFrom());

        $this->assertTrue($specificParameters->hasDateFrom());
        $this->assertEquals($dateFrom, $specificParameters->getDateFrom());
    }

    /**
     * @test
     */
    public function it_has_an_optional_date_to_parameter()
    {
        $dateTo = \DateTimeImmutable::createFromFormat(\DateTime::ATOM, '2017-04-28T15:26:12+00:00');

        $defaultParameters = new OfferSearchParameters();

        $specificParameters = $defaultParameters
            ->withDateTo($dateTo);

        $this->assertFalse($defaultParameters->hasDateTo());
        $this->assertNull($defaultParameters->getDateTo());

        $this->assertTrue($specificParameters->hasDateTo());
        $this->assertEquals($dateTo, $specificParameters->getDateTo());
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_date_from_is_after_date_to()
    {
        $dateFrom = \DateTimeImmutable::createFromFormat(\DateTime::ATOM, '2017-04-28T15:26:12+00:00');
        $dateTo = \DateTimeImmutable::createFromFormat(\DateTime::ATOM, '2017-03-01T15:26:12+00:00');

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('dateFrom should be before, or the same as, dateTo.');

        (new OfferSearchParameters())
            ->withDateTo($dateTo)
            ->withDateFrom($dateFrom);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_date_to_is_before_date_from()
    {
        $dateTo = \DateTimeImmutable::createFromFormat(\DateTime::ATOM, '2017-03-01T15:26:12+00:00');
        $dateFrom = \DateTimeImmutable::createFromFormat(\DateTime::ATOM, '2017-04-28T15:26:12+00:00');

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('dateFrom should be before, or the same as, dateTo.');

        (new OfferSearchParameters())
            ->withDateFrom($dateFrom)
            ->withDateTo($dateTo);
    }

    /**
     * @test
     */
    public function it_has_an_optional_term_ids_parameter()
    {
        $defaultParameters = new OfferSearchParameters();

        $specificParameters = $defaultParameters
            ->withTermIds(new TermId('0.11.7.3.1'))
            ->withTermIds(
                ...[
                    new TermId('aETazzetx'),
                    new TermId('1.74.57.9'),
                ]
            )
            ->withTermIds(new TermId('_could_be_anything_really_'));

        $expected = [
            new TermId('0.11.7.3.1'),
            new TermId('aETazzetx'),
            new TermId('1.74.57.9'),
            new TermId('_could_be_anything_really_'),
        ];

        $this->assertFalse($defaultParameters->hasTermIds());
        $this->assertEmpty($defaultParameters->getTermIds());

        $this->assertTrue($specificParameters->hasTermIds());
        $this->assertEquals($expected, $specificParameters->getTermIds());
    }

    /**
     * @test
     */
    public function it_has_an_optional_term_labels_parameter()
    {
        $defaultParameters = new OfferSearchParameters();

        $specificParameters = $defaultParameters
            ->withTermLabels(new TermLabel('Jeugdhuis of -centrum'))
            ->withTermLabels(
                ...[
                    new TermLabel('Cultuur- of ontmoetingscentrum'),
                    new TermLabel('Sportschuur'),
                ]
            )
            ->withTermLabels(new TermLabel('Theater'));

        $expected = [
            new TermLabel('Jeugdhuis of -centrum'),
            new TermLabel('Cultuur- of ontmoetingscentrum'),
            new TermLabel('Sportschuur'),
            new TermLabel('Theater'),
        ];

        $this->assertFalse($defaultParameters->hasTermLabels());
        $this->assertEmpty($defaultParameters->getTermLabels());

        $this->assertTrue($specificParameters->hasTermLabels());
        $this->assertEquals($expected, $specificParameters->getTermLabels());
    }

    /**
     * @test
     */
    public function it_has_an_optional_location_term_ids_parameter()
    {
        $defaultParameters = new OfferSearchParameters();

        $specificParameters = $defaultParameters
            ->withLocationTermIds(new TermId('0.11.7.3.1'))
            ->withLocationTermIds(
                ...[
                    new TermId('aETazzetx'),
                    new TermId('1.74.57.9'),
                ]
            )
            ->withLocationTermIds(new TermId('_could_be_anything_really_'));

        $expected = [
            new TermId('0.11.7.3.1'),
            new TermId('aETazzetx'),
            new TermId('1.74.57.9'),
            new TermId('_could_be_anything_really_'),
        ];

        $this->assertFalse($defaultParameters->hasLocationTermIds());
        $this->assertEmpty($defaultParameters->getLocationTermIds());

        $this->assertTrue($specificParameters->hasLocationTermIds());
        $this->assertEquals($expected, $specificParameters->getLocationTermIds());
    }

    /**
     * @test
     */
    public function it_has_an_optional_location_term_labels_parameter()
    {
        $defaultParameters = new OfferSearchParameters();

        $specificParameters = $defaultParameters
            ->withLocationTermLabels(new TermLabel('Jeugdhuis of -centrum'))
            ->withLocationTermLabels(
                ...[
                    new TermLabel('Cultuur- of ontmoetingscentrum'),
                    new TermLabel('Sportschuur'),
                ]
            )
            ->withLocationTermLabels(new TermLabel('Theater'));

        $expected = [
            new TermLabel('Jeugdhuis of -centrum'),
            new TermLabel('Cultuur- of ontmoetingscentrum'),
            new TermLabel('Sportschuur'),
            new TermLabel('Theater'),
        ];

        $this->assertFalse($defaultParameters->hasLocationTermLabels());
        $this->assertEmpty($defaultParameters->getLocationTermLabels());

        $this->assertTrue($specificParameters->hasLocationTermLabels());
        $this->assertEquals($expected, $specificParameters->getLocationTermLabels());
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

    /**
     * @test
     */
    public function it_has_an_optional_languages_parameter()
    {
        $defaultParameters = new OfferSearchParameters();

        $specificParameters = $defaultParameters
            ->withLanguages(
                new Language('nl'),
                new Language('fr')
            )
            ->withLanguages(
                new Language('de')
            );

        $this->assertFalse($defaultParameters->hasLanguages());
        $this->assertEmpty($defaultParameters->getLanguages());

        $this->assertTrue($specificParameters->hasLanguages());
        $this->assertEquals(
            [
                new Language('nl'),
                new Language('fr'),
                new Language('de'),
            ],
            $specificParameters->getLanguages()
        );
    }

    /**
     * @test
     */
    public function it_has_unique_optional_languages_as_parameter()
    {
        $defaultParameters = new OfferSearchParameters();

        $specificParameters = $defaultParameters
            ->withLanguages(
                new Language('nl'),
                new Language('fr')
            )
            ->withLanguages(
                new Language('nl')
            );

        $this->assertEquals(
            [
                new Language('nl'),
                new Language('fr'),
            ],
            $specificParameters->getLanguages()
        );
    }

    /**
     * @test
     */
    public function it_has_an_optional_facets_parameter()
    {
        $defaultParameters = new OfferSearchParameters();

        $specificParameters = $defaultParameters
            ->withFacets(
                FacetName::REGIONS(),
                FacetName::FACILITIES()
            );

        $this->assertFalse($defaultParameters->hasFacets());
        $this->assertEmpty($defaultParameters->getFacets());

        $this->assertTrue($specificParameters->hasFacets());
        $this->assertEquals(
            [
                FacetName::REGIONS(),
                FacetName::FACILITIES(),
            ],
            $specificParameters->getFacets()
        );
    }

    /**
     * @test
     */
    public function it_has_unique_optional_facets_as_parameter()
    {
        $defaultParameters = new OfferSearchParameters();

        $specificParameters = $defaultParameters
            ->withFacets(
                FacetName::REGIONS(),
                FacetName::REGIONS()
            )
            ->withFacets(
                FacetName::REGIONS()
            );

        $this->assertEquals(
            [
                FacetName::REGIONS(),
            ],
            $specificParameters->getFacets()
        );
    }
}
