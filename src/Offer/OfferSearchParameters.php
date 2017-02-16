<?php

namespace CultuurNet\UDB3\Search\Offer;

use CultuurNet\UDB3\Search\AbstractSearchParameters;
use CultuurNet\UDB3\Search\Region\RegionId;

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
