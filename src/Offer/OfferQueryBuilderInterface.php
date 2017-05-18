<?php

namespace CultuurNet\UDB3\Search\Offer;

use CultuurNet\UDB3\Address\PostalCode;
use CultuurNet\UDB3\Label\ValueObjects\LabelName;
use CultuurNet\UDB3\Language;
use CultuurNet\UDB3\PriceInfo\Price;
use CultuurNet\UDB3\Search\QueryBuilderInterface;
use CultuurNet\UDB3\Search\Creator;
use CultuurNet\UDB3\Search\GeoDistanceParameters;
use CultuurNet\UDB3\Search\Region\RegionId;
use CultuurNet\UDB3\Search\SortOrder;
use ValueObjects\Geography\Country;
use ValueObjects\Number\Natural;
use ValueObjects\StringLiteral\StringLiteral;

interface OfferQueryBuilderInterface extends QueryBuilderInterface
{
    /**
     * @param Cdbid $cdbid
     * @return static
     */
    public function withCbdIdFilter(Cdbid $cdbid);

    /**
     * @param Cdbid $locationCdbid
     * @return static
     */
    public function withLocationCbdIdFilter(Cdbid $locationCdbid);

    /**
     * @param Cdbid $organizerCdbId
     * @return static
     */
    public function withOrganizerCdbIdFilter(Cdbid $organizerCdbId);

    /**
     * @param Language[] ...$languages
     * @return static
     */
    public function withLanguagesFilter(Language ...$languages);

    /**
     * @param \DateTimeImmutable|null $from
     * @param \DateTimeImmutable|null $to
     * @return static
     */
    public function withAvailableRangeFilter(
        \DateTimeImmutable $from = null,
        \DateTimeImmutable $to = null
    );

    /**
     * @param WorkflowStatus $workflowStatus
     * @return static
     */
    public function withWorkflowStatusFilter(WorkflowStatus $workflowStatus);

    /**
     * @param \DateTimeImmutable|null $from
     * @param \DateTimeImmutable|null $to
     * @return static
     */
    public function withCreatedRangeFilter(
        \DateTimeImmutable $from = null,
        \DateTimeImmutable $to = null
    );

    /**
     * @param \DateTimeImmutable|null $from
     * @param \DateTimeImmutable|null $to
     * @return static
     */
    public function withModifiedRangeFilter(
        \DateTimeImmutable $from = null,
        \DateTimeImmutable $to = null
    );

    /**
     * @param Creator $creator
     * @return static
     */
    public function withCreatorFilter(Creator $creator);

    /**
     * @param \DateTimeImmutable|null $from
     * @param \DateTimeImmutable|null $to
     * @return static
     */
    public function withDateRangeFilter(
        \DateTimeImmutable $from = null,
        \DateTimeImmutable $to = null
    );

    /**
     * @param CalendarType $calendarType
     * @return static
     */
    public function withCalendarTypeFilter(CalendarType $calendarType);

    /**
     * @param PostalCode $postalCode
     * @return static
     */
    public function withPostalCodeFilter(PostalCode $postalCode);

    /**
     * @param Country $country
     * @return static
     */
    public function withAddressCountryFilter(Country $country);

    /**
     * @param StringLiteral $regionIndexName
     * @param StringLiteral $regionDocumentType
     * @param RegionId $regionId
     * @return static
     */
    public function withRegionFilter(
        StringLiteral $regionIndexName,
        StringLiteral $regionDocumentType,
        RegionId $regionId
    );

    /**
     * @param GeoDistanceParameters $geoDistance
     * @return static
     */
    public function withGeoDistanceFilter(GeoDistanceParameters $geoDistance);

    /**
     * @param AudienceType $audienceType
     * @return static
     */
    public function withAudienceTypeFilter(AudienceType $audienceType);

    /**
     * @param Natural|null $minimum
     * @param Natural|null $maximum
     * @return static
     */
    public function withAgeRangeFilter(Natural $minimum = null, Natural $maximum = null);

    /**
     * @param Price|null $minimum
     * @param Price|null $maximum
     * @return static
     */
    public function withPriceRangeFilter(Price $minimum = null, Price $maximum = null);

    /**
     * @param bool $include
     *   When set to true only offers with at least one media object will be
     *   included. When set to false offers with media objects will be excluded.
     * @return static
     */
    public function withMediaObjectsFilter($include);

    /**
     * @param bool $include
     *   When set to true only UiTPAS offers will be included. When set to
     *   false UiTPAS offers will be excluded.
     * @return static
     */
    public function withUiTPASFilter($include);

    /**
     * @param TermId $termId
     * @return static
     */
    public function withTermIdFilter(TermId $termId);

    /**
     * @param TermLabel $termLabel
     * @return static
     */
    public function withTermLabelFilter(TermLabel $termLabel);

    /**
     * @param TermId $locationTermId
     * @return static
     */
    public function withLocationTermIdFilter(TermId $locationTermId);

    /**
     * @param TermLabel $locationTermLabel
     * @return static
     */
    public function withLocationTermLabelFilter(TermLabel $locationTermLabel);

    /**
     * @param LabelName $label
     * @return static
     */
    public function withLabelFilter(LabelName $label);

    /**
     * @param LabelName $locationLabel
     * @return static
     */
    public function withLocationLabelFilter(LabelName $locationLabel);

    /**
     * @param LabelName $organizerLabel
     * @return static
     */
    public function withOrganizerLabelFilter(LabelName $organizerLabel);

    /**
     * @param FacetName $facetName
     * @return static
     */
    public function withFacet(FacetName $facetName);

    /**
     * @param SortBy $sortBy
     * @param SortOrder $sortOrder
     * @return static
     */
    public function withSort(SortBy $sortBy, SortOrder $sortOrder);
}
