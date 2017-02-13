<?php

namespace CultuurNet\UDB3\Search;

use ValueObjects\StringLiteral\StringLiteral;
use ValueObjects\Web\Url;

class OfferSearchParameters extends AbstractSearchParameters
{
    /**
     * @var StringLiteral
     */
    private $regionId;

    /**
     * @param StringLiteral $regionId
     * @return OfferSearchParameters
     */
    public function withRegionId(StringLiteral $regionId)
    {
        $c = clone $this;
        $c->regionId = $regionId;
        return $c;
    }

    /**
     * @return StringLiteral
     */
    public function getRegionId()
    {
        return $this->regionId;
    }
}
