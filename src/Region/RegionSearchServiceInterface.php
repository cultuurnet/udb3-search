<?php

namespace CultuurNet\UDB3\Search;

use ValueObjects\Number\Natural;
use ValueObjects\StringLiteral\StringLiteral;

interface RegionSearchServiceInterface
{
    /**
     * @param StringLiteral $input
     * @param Natural|null $maxSuggestions
     * @return RegionId[]
     */
    public function suggest(StringLiteral $input, Natural $maxSuggestions = null);
}
