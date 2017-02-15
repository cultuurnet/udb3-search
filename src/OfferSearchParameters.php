<?php

namespace CultuurNet\UDB3\Search;

use ValueObjects\StringLiteral\StringLiteral;
use ValueObjects\Web\Url;

class OfferSearchParameters extends AbstractSearchParameters
{
    /**
     * @var RegionId
     */
    private $regionId;

    /**
     * @param RegionId $regionId
     * @return OfferSearchParameters
     */
    public function withRegionId(RegionId $regionId)
    {
        $c = clone $this;
        $c->regionId = $regionId;
        return $c;
    }

    /**
     * @return RegionId
     */
    public function getRegionId()
    {
        return $this->regionId;
    }
}
