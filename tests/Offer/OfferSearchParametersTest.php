<?php

namespace CultuurNet\UDB3\Search\Offer;

use CultuurNet\UDB3\Label\ValueObjects\LabelName;
use CultuurNet\UDB3\Language;
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
}
