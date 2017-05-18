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
     * @return OfferQueryBuilderInterface
     */
    public function withCbdIdFilter(Cdbid $cdbid);

    /**
     * @param Cdbid $locationCdbid
     * @return OfferQueryBuilderInterface
     */
    public function withLocationCbdIdFilter(Cdbid $locationCdbid);

    /**
     * @param Cdbid $organizerCdbId
     * @return OfferQueryBuilderInterface
     */
    public function withOrganizerCdbIdFilter(Cdbid $organizerCdbId);

    /**
     * @param Language $language
     * @return OfferQueryBuilderInterface
     */
    public function withLanguageFilter(Language $language);

    /**
     * @param \DateTimeImmutable|null $from
     * @param \DateTimeImmutable|null $to
     * @return OfferQueryBuilderInterface
     */
    public function withAvailableRangeFilter(
        \DateTimeImmutable $from = null,
        \DateTimeImmutable $to = null
    );

    /**
     * @param WorkflowStatus $workflowStatus
     * @return OfferQueryBuilderInterface
     */
    public function withWorkflowStatusFilter(WorkflowStatus $workflowStatus);

    /**
     * @param \DateTimeImmutable|null $from
     * @param \DateTimeImmutable|null $to
     * @return OfferQueryBuilderInterface
     */
    public function withCreatedRangeFilter(
        \DateTimeImmutable $from = null,
        \DateTimeImmutable $to = null
    );

    /**
     * @param \DateTimeImmutable|null $from
     * @param \DateTimeImmutable|null $to
     * @return OfferQueryBuilderInterface
     */
    public function withModifiedRangeFilter(
        \DateTimeImmutable $from = null,
        \DateTimeImmutable $to = null
    );

    /**
     * @param Creator $creator
     * @return OfferQueryBuilderInterface
     */
    public function withCreatorFilter(Creator $creator);

    /**
     * @param \DateTimeImmutable|null $from
     * @param \DateTimeImmutable|null $to
     * @return OfferQueryBuilderInterface
     */
    public function withDateRangeFilter(
        \DateTimeImmutable $from = null,
        \DateTimeImmutable $to = null
    );

    /**
     * @param CalendarType $calendarType
     * @return OfferQueryBuilderInterface
     */
    public function withCalendarTypeFilter(CalendarType $calendarType);

    /**
     * @param PostalCode $postalCode
     * @return OfferQueryBuilderInterface
     */
    public function withPostalCodeFilter(PostalCode $postalCode);

    /**
     * @param Country $country
     * @return OfferQueryBuilderInterface
     */
    public function withAddressCountryFilter(Country $country);

    /**
     * @param StringLiteral $regionIndexName
     * @param StringLiteral $regionDocumentType
     * @param RegionId $regionId
     * @return OfferQueryBuilderInterface
     */
    public function withRegionFilter(
        StringLiteral $regionIndexName,
        StringLiteral $regionDocumentType,
        RegionId $regionId
    );

    /**
     * @param GeoDistanceParameters $geoDistance
     * @return OfferQueryBuilderInterface
     */
    public function withGeoDistanceFilter(GeoDistanceParameters $geoDistance);

    /**
     * @param AudienceType $audienceType
     * @return OfferQueryBuilderInterface
     */
    public function withAudienceTypeFilter(AudienceType $audienceType);

    /**
     * @param Natural|null $minimum
     * @param Natural|null $maximum
     * @return OfferQueryBuilderInterface
     */
    public function withAgeRangeFilter(Natural $minimum = null, Natural $maximum = null);

    /**
     * @param Price|null $minimum
     * @param Price|null $maximum
     * @return OfferQueryBuilderInterface
     */
    public function withPriceRangeFilter(Price $minimum = null, Price $maximum = null);

    /**
     * @param bool $include
     *   When set to true only offers with at least one media object will be
     *   included. When set to false offers with media objects will be excluded.
     * @return OfferQueryBuilderInterface
     */
    public function withMediaObjectsFilter($include);

    /**
     * @param bool $include
     *   When set to true only UiTPAS offers will be included. When set to
     *   false UiTPAS offers will be excluded.
     * @return OfferQueryBuilderInterface
     */
    public function withUiTPASFilter($include);

    /**
     * @param TermId $termId
     * @return OfferQueryBuilderInterface
     */
    public function withTermIdFilter(TermId $termId);

    /**
     * @param TermLabel $termLabel
     * @return OfferQueryBuilderInterface
     */
    public function withTermLabelFilter(TermLabel $termLabel);

    /**
     * @param TermId $locationTermId
     * @return OfferQueryBuilderInterface
     */
    public function withLocationTermIdFilter(TermId $locationTermId);

    /**
     * @param TermLabel $locationTermLabel
     * @return OfferQueryBuilderInterface
     */
    public function withLocationTermLabelFilter(TermLabel $locationTermLabel);

    /**
     * @param LabelName $label
     * @return OfferQueryBuilderInterface
     */
    public function withLabelFilter(LabelName $label);

    /**
     * @param LabelName $locationLabel
     * @return OfferQueryBuilderInterface
     */
    public function withLocationLabelFilter(LabelName $locationLabel);

    /**
     * @param LabelName $organizerLabel
     * @return OfferQueryBuilderInterface
     */
    public function withOrganizerLabelFilter(LabelName $organizerLabel);

    /**
     * @param FacetName $facetName
     * @return OfferQueryBuilderInterface
     */
    public function withFacet(FacetName $facetName);

    /**
     * @param SortBy $sortBy
     * @param SortOrder $sortOrder
     * @return OfferQueryBuilderInterface
     */
    public function withSort(SortBy $sortBy, SortOrder $sortOrder);
}
