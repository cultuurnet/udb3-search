<?php

namespace CultuurNet\UDB3\Search\Offer;

use CultuurNet\UDB3\Address\PostalCode;
use CultuurNet\UDB3\Label\ValueObjects\LabelName;
use CultuurNet\UDB3\PriceInfo\Price;
use CultuurNet\UDB3\Language;
use CultuurNet\UDB3\Search\AbstractSearchParameters;
use CultuurNet\UDB3\Search\Creator;
use CultuurNet\UDB3\Search\GeoDistanceParameters;
use CultuurNet\UDB3\Search\Region\RegionId;
use ValueObjects\Geography\Country;
use ValueObjects\Number\Natural;
use ValueObjects\StringLiteral\StringLiteral;

class OfferSearchParameters extends AbstractSearchParameters
{
    /**
     * @var Cdbid
     */
    private $cdbid;

    /**
     * @var Cdbid
     */
    private $locationCdbid;

    /**
     * @var Cdbid
     */
    private $organizerCdbid;

    /**
     * @var \DateTimeImmutable
     */
    private $availableFrom;

    /**
     * @var \DateTimeImmutable
     */
    private $availableTo;

    /**
     * @var WorkflowStatus
     */
    private $workflowStatus;

    /**
     * @var RegionId
     */
    private $regionId;

    /**
     * @var StringLiteral
     */
    private $regionIndexName;

    /**
     * @var StringLiteral
     */
    private $regionDocumentType;

    /**
     * @var GeoDistanceParameters
     */
    private $geoDistanceParameters;

    /**
     * @var PostalCode
     */
    private $postalCode;

    /**
     * @var Country
     */
    private $addressCountry;

    /**
     * @var Natural
     */
    private $minimumAge;

    /**
     * @var Natural
     */
    private $maximumAge;

    /**
     * @var Price
     */
    private $price;

    /**
     * @var Price
     */
    private $minimumPrice;

    /**
     * @var Price
     */
    private $maximumPrice;

    /**
     * @var AudienceType
     */
    private $audienceType;

    /**
     * @var bool
     */
    private $mediaObjectsToggle;

    /**
     * @var CalendarType
     */
    private $calendarType;

    /**
     * @var \DateTimeImmutable
     */
    private $dateFrom;

    /**
     * @var \DateTimeImmutable
     */
    private $dateTo;

    /**
     * @var TermId[]
     */
    private $termIds = [];

    /**
     * @var TermLabel[]
     */
    private $termLabels = [];

    /**
     * @var TermId[]
     */
    private $locationTermIds = [];

    /**
     * @var TermLabel[]
     */
    private $locationTermLabels = [];

    /**
     * @var bool
     */
    private $uitpasToggle;

    /**
     * @var LabelName[]
     */
    private $labels = [];

    /**
     * @var LabelName[]
     */
    private $locationLabels = [];

    /**
     * @var LabelName[]
     */
    private $organizerLabels = [];

    /**
     * @var Language[]
     */
    private $languages = [];

    /**
     * @var FacetName[]
     */
    private $facets = [];

    /**
     * @var \DateTimeImmutable|null
     */
    private $createdFrom;

    /**
     * @var \DateTimeImmutable|null
     */
    private $createdTo;

    /**
     * @var \DateTimeImmutable|null
     */
    private $modifiedFrom;

    /**
     * @var \DateTimeImmutable|null
     */
    private $modifiedTo;

    /**
     * @var Creator
     */
    private $creator;

    /**
     * @var Sorting[]
     */
    private $sorting = [];

    /**
     * @param Cdbid $cdbid
     * @return OfferSearchParameters
     */
    public function withCdbid(Cdbid $cdbid)
    {
        $c = clone $this;
        $c->cdbid = $cdbid;
        return $c;
    }

    /**
     * @return bool
     */
    public function hasCdbid()
    {
        return (bool) $this->cdbid;
    }

    /**
     * @return Cdbid
     */
    public function getCdbid()
    {
        return $this->cdbid;
    }

    /**
     * @param Cdbid $locationCdbid
     * @return OfferSearchParameters
     */
    public function withLocationCdbid(Cdbid $locationCdbid)
    {
        $c = clone $this;
        $c->locationCdbid = $locationCdbid;
        return $c;
    }

    /**
     * @return bool
     */
    public function hasLocationCdbid()
    {
        return (bool) $this->locationCdbid;
    }

    /**
     * @return Cdbid
     */
    public function getLocationCdbid()
    {
        return $this->locationCdbid;
    }

    /**
     * @param Cdbid $organizerCdbid
     * @return OfferSearchParameters
     */
    public function withOrganizerCdbid(Cdbid $organizerCdbid)
    {
        $c = clone $this;
        $c->organizerCdbid = $organizerCdbid;
        return $c;
    }

    /**
     * @return bool
     */
    public function hasOrganizerCdbid()
    {
        return (bool) $this->organizerCdbid;
    }

    /**
     * @return Cdbid
     */
    public function getOrganizerCdbid()
    {
        return $this->organizerCdbid;
    }

    /**
     * @param \DateTimeImmutable $availableFrom
     * @return OfferSearchParameters
     */
    public function withAvailableFrom(\DateTimeImmutable $availableFrom)
    {
        $this->guardAvailableRange($availableFrom, $this->availableTo);

        $c = clone $this;
        $c->availableFrom = $availableFrom;
        return $c;
    }

    /**
     * @return bool
     */
    public function hasAvailableFrom()
    {
        return (bool) $this->availableFrom;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getAvailableFrom()
    {
        return $this->availableFrom;
    }

    /**
     * @param \DateTimeImmutable $availableTo
     * @return OfferSearchParameters
     */
    public function withAvailableTo(\DateTimeImmutable $availableTo)
    {
        $this->guardAvailableRange($this->availableFrom, $availableTo);

        $c = clone $this;
        $c->availableTo = $availableTo;
        return $c;
    }

    /**
     * @return bool
     */
    public function hasAvailableTo()
    {
        return (bool) $this->availableTo;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getAvailableTo()
    {
        return $this->availableTo;
    }

    /**
     * @param WorkflowStatus $workflowStatus
     * @return OfferSearchParameters
     */
    public function withWorkflowStatus(
        WorkflowStatus $workflowStatus
    ) {
        $c = clone $this;
        $c->workflowStatus = $workflowStatus;
        return $c;
    }

    /**
     * @return bool
     */
    public function hasWorkflowStatus()
    {
        return (bool) $this->workflowStatus;
    }

    /**
     * @return WorkflowStatus
     */
    public function getWorkflowStatus()
    {
        return $this->workflowStatus;
    }

    /**
     * @param RegionId $regionId
     * @param StringLiteral $regionIndexName
     * @param StringLiteral $regionDocumentType
     * @return OfferSearchParameters
     */
    public function withRegion(
        RegionId $regionId,
        StringLiteral $regionIndexName,
        StringLiteral $regionDocumentType
    ) {
        $c = clone $this;
        $c->regionId = $regionId;
        $c->regionIndexName = $regionIndexName;
        $c->regionDocumentType = $regionDocumentType;
        return $c;
    }

    /**
     * @return RegionId
     */
    public function getRegionId()
    {
        return $this->regionId;
    }

    /**
     * @return StringLiteral
     */
    public function getRegionIndexName()
    {
        return $this->regionIndexName;
    }

    /**
     * @return StringLiteral
     */
    public function getRegionDocumentType()
    {
        return $this->regionDocumentType;
    }

    /**
     * @param GeoDistanceParameters $geoDistanceParameters
     * @return OfferSearchParameters
     */
    public function withGeoDistanceParameters(GeoDistanceParameters $geoDistanceParameters)
    {
        $c = clone $this;
        $c->geoDistanceParameters = $geoDistanceParameters;
        return $c;
    }

    /**
     * @return bool
     */
    public function hasGeoDistanceParameters()
    {
        return (bool) $this->geoDistanceParameters;
    }

    /**
     * @return GeoDistanceParameters|null
     */
    public function getGeoDistanceParameters()
    {
        return $this->geoDistanceParameters;
    }

    /**
     * @param PostalCode $postalCode
     * @return OfferSearchParameters
     */
    public function withPostalCode(PostalCode $postalCode)
    {
        $c = clone $this;
        $c->postalCode = $postalCode;
        return $c;
    }

    /**
     * @return bool
     */
    public function hasPostalCode()
    {
        return (bool) $this->postalCode;
    }

    /**
     * @return PostalCode
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param Country $addressCountry
     * @return OfferSearchParameters
     */
    public function withAddressCountry(Country $addressCountry)
    {
        $c = clone $this;
        $c->addressCountry = $addressCountry;
        return $c;
    }

    /**
     * @return bool
     */
    public function hasAddressCountry()
    {
        return (bool) $this->addressCountry;
    }

    /**
     * @return Country
     */
    public function getAddressCountry()
    {
        return $this->addressCountry;
    }

    /**
     * @param Natural $minimumAge
     * @return OfferSearchParameters
     * @throws \InvalidArgumentException
     */
    public function withMinimumAge(Natural $minimumAge)
    {
        $this->guardAgeRange($minimumAge, $this->getMaximumAge());

        $c = clone $this;
        $c->minimumAge = $minimumAge;
        return $c;
    }

    /**
     * @return bool
     */
    public function hasMinimumAge()
    {
        return (bool) $this->minimumAge;
    }

    /**
     * @return Natural
     */
    public function getMinimumAge()
    {
        return $this->minimumAge;
    }

    /**
     * @param Natural $maximumAge
     * @return OfferSearchParameters
     * @throws \InvalidArgumentException
     */
    public function withMaximumAge(Natural $maximumAge)
    {
        $this->guardAgeRange($this->getMinimumAge(), $maximumAge);

        $c = clone $this;
        $c->maximumAge = $maximumAge;
        return $c;
    }

    /**
     * @return bool
     */
    public function hasMaximumAge()
    {
        return (bool) $this->maximumAge;
    }

    /**
     * @return Natural
     */
    public function getMaximumAge()
    {
        return $this->maximumAge;
    }

    /**
     * @return bool
     */
    public function hasAgeRange()
    {
        return $this->hasMinimumAge() || $this->hasMaximumAge();
    }

    /**
     * @param Price $price
     * @return OfferSearchParameters
     */
    public function withPrice(Price $price)
    {
        $c = clone $this;
        $c->price = $price;
        return $c;
    }

    /**
     * @return Price|null
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return bool
     */
    public function hasPrice()
    {
        return (bool) $this->price;
    }

    /**
     * @param Price $minimumPrice
     * @return OfferSearchParameters
     * @throws \InvalidArgumentException
     */
    public function withMinimumPrice(Price $minimumPrice)
    {
        $this->guardPriceRange($minimumPrice, $this->getMaximumPrice());

        $c = clone $this;
        $c->minimumPrice = $minimumPrice;
        return $c;
    }

    /**
     * @return Price
     */
    public function getMinimumPrice()
    {
        return $this->minimumPrice;
    }

    /**
     * @return bool
     */
    public function hasMinimumPrice()
    {
        return (bool) $this->minimumPrice;
    }

    /**
     * @param Price $maximumPrice
     * @return OfferSearchParameters
     * @throws \InvalidArgumentException
     */
    public function withMaximumPrice(Price $maximumPrice)
    {
        $this->guardPriceRange($this->getMinimumPrice(), $maximumPrice);

        $c = clone $this;
        $c->maximumPrice = $maximumPrice;
        return $c;
    }

    /**
     * @return Price
     */
    public function getMaximumPrice()
    {
        return $this->maximumPrice;
    }

    /**
     * @return bool
     */
    public function hasMaximumPrice()
    {
        return (bool) $this->maximumPrice;
    }

    /**
     * @return bool
     */
    public function hasPriceRange()
    {
        return $this->hasMinimumPrice() || $this->hasMaximumPrice();
    }

    /**
     * @param AudienceType $audienceType
     * @return OfferSearchParameters
     */
    public function withAudienceType(AudienceType $audienceType)
    {
        $c = clone $this;
        $c->audienceType = $audienceType;
        return $c;
    }

    /**
     * @return AudienceType
     */
    public function getAudienceType()
    {
        return $this->audienceType;
    }

    /**
     * @return bool
     */
    public function hasAudienceType()
    {
        return (bool) $this->audienceType;
    }

    /**
     * @param bool $mediaObjectsToggle
     * @return OfferSearchParameters
     */
    public function withMediaObjectsToggle($mediaObjectsToggle)
    {
        $c = clone $this;
        $c->mediaObjectsToggle = filter_var($mediaObjectsToggle, FILTER_VALIDATE_BOOLEAN);
        return $c;
    }

    /**
     * @return bool
     */
    public function hasMediaObjectsToggle()
    {
        return !is_null($this->mediaObjectsToggle);
    }

    /**
     * @return bool
     */
    public function getMediaObjectsToggle()
    {
        return $this->mediaObjectsToggle;
    }

    /**
     * @param bool $uitpasToggle
     * @return OfferSearchParameters
     * @throws \InvalidArgumentException
     */
    public function withUitpasToggle($uitpasToggle)
    {
        if (!is_bool($uitpasToggle)) {
            throw new \InvalidArgumentException(
                'UiTPASToggle should be of type boolean.'
            );
        }

        $c = clone $this;
        $c->uitpasToggle = $uitpasToggle;
        return $c;
    }

    /**
     * @return bool
     */
    public function hasUitpasToggle()
    {
        return !is_null($this->uitpasToggle);
    }

    /**
     * @return bool
     */
    public function getUitpasToggle()
    {
        return $this->uitpasToggle;
    }

    /**
     * @param CalendarType $calendarType
     * @return OfferSearchParameters
     */
    public function withCalendarType(CalendarType $calendarType)
    {
        $c = clone $this;
        $c->calendarType = $calendarType;
        return $c;
    }

    /**
     * @return bool
     */
    public function hasCalendarType()
    {
        return (bool) $this->calendarType;
    }

    /**
     * @return CalendarType
     */
    public function getCalendarType()
    {
        return $this->calendarType;
    }

    /**
     * @param \DateTimeImmutable $dateFrom
     * @return OfferSearchParameters
     */
    public function withDateFrom(\DateTimeImmutable $dateFrom)
    {
        $this->guardDateRange($dateFrom, $this->dateTo);

        $c = clone $this;
        $c->dateFrom = $dateFrom;
        return $c;
    }

    /**
     * @return bool
     */
    public function hasDateFrom()
    {
        return (bool) $this->dateFrom;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDateFrom()
    {
        return $this->dateFrom;
    }

    /**
     * @param \DateTimeImmutable $dateTo
     * @return OfferSearchParameters
     */
    public function withDateTo(\DateTimeImmutable $dateTo)
    {
        $this->guardDateRange($this->dateFrom, $dateTo);

        $c = clone $this;
        $c->dateTo = $dateTo;
        return $c;
    }

    /**
     * @return bool
     */
    public function hasDateTo()
    {
        return (bool) $this->dateTo;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDateTo()
    {
        return $this->dateTo;
    }

    /**
     * @param TermId[] ...$termIds
     * @return OfferSearchParameters
     */
    public function withTermIds(TermId ...$termIds)
    {
        $c = clone $this;
        $c->termIds = array_merge($this->termIds, $termIds);
        return $c;
    }

    /**
     * @return bool
     */
    public function hasTermIds()
    {
        return !empty($this->termIds);
    }

    /**
     * @return TermId[]
     */
    public function getTermIds()
    {
        return $this->termIds;
    }

    /**
     * @param TermLabel[] ...$termLabels
     * @return OfferSearchParameters
     */
    public function withTermLabels(TermLabel ...$termLabels)
    {
        $c = clone $this;
        $c->termLabels = array_merge($this->termLabels, $termLabels);
        return $c;
    }

    /**
     * @return bool
     */
    public function hasTermLabels()
    {
        return !empty($this->termLabels);
    }

    /**
     * @return TermLabel[]
     */
    public function getTermLabels()
    {
        return $this->termLabels;
    }

    /**
     * @param TermId[] ...$termIds
     * @return OfferSearchParameters
     */
    public function withLocationTermIds(TermId ...$termIds)
    {
        $c = clone $this;
        $c->locationTermIds = array_merge($this->locationTermIds, $termIds);
        return $c;
    }

    /**
     * @return bool
     */
    public function hasLocationTermIds()
    {
        return !empty($this->locationTermIds);
    }

    /**
     * @return TermId[]
     */
    public function getLocationTermIds()
    {
        return $this->locationTermIds;
    }

    /**
     * @param TermLabel[] ...$termLabels
     * @return OfferSearchParameters
     */
    public function withLocationTermLabels(TermLabel ...$termLabels)
    {
        $c = clone $this;
        $c->locationTermLabels = array_merge($this->locationTermLabels, $termLabels);
        return $c;
    }

    /**
     * @return bool
     */
    public function hasLocationTermLabels()
    {
        return !empty($this->locationTermLabels);
    }

    /**
     * @return TermLabel[]
     */
    public function getLocationTermLabels()
    {
        return $this->locationTermLabels;
    }

    /**
     * @param LabelName[] ...$labelNames
     * @return OfferSearchParameters
     */
    public function withLabels(LabelName ...$labelNames)
    {
        $c = clone $this;
        $c->labels = array_merge($c->labels, $labelNames);
        return $c;
    }

    /**
     * @param LabelName[] ...$labelNames
     * @return OfferSearchParameters
     */
    public function withLocationLabels(LabelName ...$labelNames)
    {
        $c = clone $this;
        $c->locationLabels = array_merge($c->locationLabels, $labelNames);
        return $c;
    }

    /**
     * @param LabelName[] ...$labelNames
     * @return OfferSearchParameters
     */
    public function withOrganizerLabels(LabelName ...$labelNames)
    {
        $c = clone $this;
        $c->organizerLabels = array_merge($c->organizerLabels, $labelNames);
        return $c;
    }

    /**
     * @return bool
     */
    public function hasLabels()
    {
        return !empty($this->labels);
    }

    /**
     * @return LabelName[]
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * @return bool
     */
    public function hasLocationLabels()
    {
        return !empty($this->locationLabels);
    }

    /**
     * @return LabelName[]
     */
    public function getLocationLabels()
    {
        return $this->locationLabels;
    }

    /**
     * @return bool
     */
    public function hasOrganizerLabels()
    {
        return !empty($this->organizerLabels);
    }

    /**
     * @return LabelName[]
     */
    public function getOrganizerLabels()
    {
        return $this->organizerLabels;
    }

    /**
     * @param Language[] $languages
     * @return OfferSearchParameters
     */
    public function withLanguages(Language ...$languages)
    {
        $c = clone $this;
        $c->languages = array_unique(array_merge($this->languages, $languages));
        return $c;
    }

    /**
     * @return bool
     */
    public function hasLanguages()
    {
        return !empty($this->languages);
    }

    /**
     * @return Language[]
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * @param FacetName[] ...$facetNames
     * @return OfferSearchParameters
     */
    public function withFacets(FacetName ...$facetNames)
    {
        $c = clone $this;
        $c->facets = array_unique($facetNames);
        return $c;
    }

    /**
     * @return bool
     */
    public function hasFacets()
    {
        return !empty($this->facets);
    }

    /**
     * @return FacetName[]
     */
    public function getFacets()
    {
        return $this->facets;
    }

    /**
     * @param \DateTimeImmutable $from
     * @return OfferSearchParameters
     */
    public function withCreatedFrom(\DateTimeImmutable $from)
    {
        return $this->withMetadataDateFrom(MetaDataDateType::CREATED(), $from);
    }

    /**
     * @return bool
     */
    public function hasCreatedFrom()
    {
        return (bool) $this->createdFrom;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedFrom()
    {
        return $this->createdFrom;
    }

    /**
     * @param \DateTimeImmutable $to
     * @return OfferSearchParameters
     */
    public function withCreatedTo(\DateTimeImmutable $to)
    {
        return $this->withMetadataDateTo(MetaDataDateType::CREATED(), $to);
    }

    /**
     * @return bool
     */
    public function hasCreatedTo()
    {
        return (bool) $this->createdTo;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedTo()
    {
        return $this->createdTo;
    }

    /**
     * @param \DateTimeImmutable $from
     * @return OfferSearchParameters
     */
    public function withModifiedFrom(\DateTimeImmutable $from)
    {
        return $this->withMetadataDateFrom(MetaDataDateType::MODIFIED(), $from);
    }

    /**
     * @return bool
     */
    public function hasModifiedFrom()
    {
        return (bool) $this->modifiedFrom;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getModifiedFrom()
    {
        return $this->modifiedFrom;
    }

    /**
     * @param \DateTimeImmutable $to
     * @return OfferSearchParameters
     */
    public function withModifiedTo(\DateTimeImmutable $to)
    {
        return $this->withMetadataDateTo(MetaDataDateType::MODIFIED(), $to);
    }

    /**
     * @return bool
     */
    public function hasModifiedTo()
    {
        return (bool) $this->modifiedTo;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getModifiedTo()
    {
        return $this->modifiedTo;
    }

    /**
     * @param MetaDataDateType $dateType
     * @param \DateTimeImmutable $dateFrom
     * @return OfferSearchParameters
     */
    private function withMetadataDateFrom(MetaDataDateType $dateType, \DateTimeImmutable $dateFrom)
    {
        $this->guardParameterDateRange((string) $dateType, $dateFrom, $this->{$dateType . 'To'});

        $c = clone $this;
        $c->{$dateType . 'From'} = $dateFrom;
        return $c;
    }

    /**
     * @param MetaDataDateType $dateType
     * @param \DateTimeImmutable $dateTo
     * @return OfferSearchParameters
     */
    private function withMetadataDateTo(MetaDataDateType $dateType, \DateTimeImmutable $dateTo)
    {
        $this->guardParameterDateRange((string) $dateType, $this->{$dateType . 'From'}, $dateTo);

        $c = clone $this;
        $c->{$dateType . 'To'} = $dateTo;
        return $c;
    }

    /**
     * @param Creator $creator
     * @return OfferSearchParameters
     */
    public function withCreator(Creator $creator)
    {
        $c = clone $this;
        $c->creator = $creator;
        return $c;
    }

    /**
     * @return bool
     */
    public function hasCreator()
    {
        return (bool) $this->creator;
    }

    /**
     * @return Creator
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * @param Sorting[] ...$sorting
     * @return OfferSearchParameters
     */
    public function withSorting(Sorting ...$sorting)
    {
        $c = clone $this;
        $c->sorting = $sorting;
        return $c;
    }

    /**
     * @return bool
     */
    public function hasSorting()
    {
        return !empty($this->sorting);
    }

    /**
     * @return Sorting[]
     */
    public function getSorting()
    {
        return $this->sorting;
    }

    /**
     * @param \DateTimeImmutable|null $availableFrom
     * @param \DateTimeImmutable|null $availableTo
     */
    private function guardAvailableRange(
        \DateTimeImmutable $availableFrom = null,
        \DateTimeImmutable $availableTo = null
    ) {
        if (!is_null($availableFrom) && !is_null($availableTo) && $availableFrom > $availableTo) {
            throw new \InvalidArgumentException(
                'availableFrom should be equal to or smaller than availableTo.'
            );
        }
    }

    /**
     * @param Natural|null $minAge
     * @param Natural|null $maxAge
     * @throws \InvalidArgumentException
     */
    private function guardAgeRange($minAge, $maxAge)
    {
        if (!is_null($minAge) && !is_null($maxAge)) {
            if ($minAge->toInteger() > $maxAge->toInteger()) {
                throw new \InvalidArgumentException(
                    'Minimum age should be smaller or equal to maximum age.'
                );
            }
        }
    }

    /**
     * @param Price|null $minimumPrice
     * @param Price|null $maximumPrice
     * @throws \InvalidArgumentException
     */
    private function guardPriceRange($minimumPrice, $maximumPrice)
    {
        if (!is_null($minimumPrice) && !is_null($maximumPrice)) {
            if ($minimumPrice->toFloat() > $maximumPrice->toFloat()) {
                throw new \InvalidArgumentException(
                    'Minimum price should be smaller or equal to maximum price.'
                );
            }
        }
    }

    /**
     * @param \DateTimeImmutable|null $dateFrom
     * @param \DateTimeImmutable|null $dateTo
     * @throws \InvalidArgumentException
     */
    private function guardDateRange(
        \DateTimeImmutable $dateFrom = null,
        \DateTimeImmutable $dateTo = null
    ) {
        if (!is_null($dateFrom) && !is_null($dateTo) && $dateFrom > $dateTo) {
            throw new \InvalidArgumentException(
                'dateFrom should be before, or the same as, dateTo.'
            );
        }
    }

    /**
     * @param \DateTimeImmutable|null $dateFrom
     * @param \DateTimeImmutable|null $dateTo
     * @param string $parameterName
     * @throws \InvalidArgumentException
     */
    private function guardParameterDateRange(
        $parameterName,
        \DateTimeImmutable $dateFrom = null,
        \DateTimeImmutable $dateTo = null
    ) {
        if (!is_null($dateFrom) && !is_null($dateTo) && $dateFrom > $dateTo) {
            throw new \InvalidArgumentException(
                sprintf('%1$sFrom should be before, or the same as, %1$sTo.', $parameterName)
            );
        }
    }
}
