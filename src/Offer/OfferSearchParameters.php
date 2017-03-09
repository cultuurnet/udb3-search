<?php

namespace CultuurNet\UDB3\Search\Offer;

use CultuurNet\UDB3\Search\AbstractSearchParameters;
use CultuurNet\UDB3\Search\Region\RegionId;
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
}
