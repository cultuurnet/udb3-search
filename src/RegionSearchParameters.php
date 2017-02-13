<?php

namespace CultuurNet\UDB3\Search;

use ValueObjects\StringLiteral\StringLiteral;

class RegionSearchParameters extends AbstractSearchParameters
{
    /**
     * @var StringLiteral
     */
    private $name;

    /**
     * @param StringLiteral $name
     * @return RegionSearchParameters
     */
    public function withName(StringLiteral $name)
    {
        $c = clone $this;
        $c->name = $name;
        return $c;
    }

    /**
     * @return StringLiteral
     */
    public function getName()
    {
        return $this->name;
    }
}
