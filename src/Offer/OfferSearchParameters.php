<?php

namespace CultuurNet\UDB3\Search\Offer;

use CultuurNet\UDB3\Label\ValueObjects\LabelName;
use CultuurNet\UDB3\PriceInfo\Price;
use CultuurNet\UDB3\Language;
use CultuurNet\UDB3\Search\AbstractSearchParameters;
use CultuurNet\UDB3\Search\GeoDistanceParameters;
use CultuurNet\UDB3\Search\Region\RegionId;
use ValueObjects\Number\Natural;
use ValueObjects\StringLiteral\StringLiteral;

class OfferSearchParameters extends AbstractSearchParameters
{
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
}
