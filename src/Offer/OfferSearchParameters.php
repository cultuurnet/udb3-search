<?php

namespace CultuurNet\UDB3\Search\Offer;

use CultuurNet\UDB3\Search\AbstractSearchParameters;
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
     * @var Natural
     */
    private $minimumAge;

    /**
     * @var Natural
     */
    private $maximumAge;

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
     * @param Natural $minimumAge
     * @return OfferSearchParameters
     * @throws \InvalidArgumentException
     */
    public function withMinimumAge(Natural $minimumAge)
    {
        $this->guardRange($minimumAge, $this->getMaximumAge());

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
        $this->guardRange($this->getMinimumAge(), $maximumAge);

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
     * @param Natural|null $minAge
     * @param Natural|null $maxAge
     * @throws \InvalidArgumentException
     */
    private function guardRange($minAge, $maxAge)
    {
        if (!is_null($minAge) && !is_null($maxAge)) {
            if ($minAge->toInteger() > $maxAge->toInteger()) {
                throw new \InvalidArgumentException(
                    'Minimum age should be smaller or equal to maximum age.'
                );
            }
        }
    }
}
