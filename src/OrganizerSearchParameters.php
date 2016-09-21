<?php

namespace CultuurNet\UDB3\Search;

use ValueObjects\String\String as StringLiteral;

class OrganizerSearchParameters extends AbstractSearchParameters
{
    /**
     * @var StringLiteral|null
     */
    private $name;

    /**
     * @param StringLiteral $name
     * @return OrganizerSearchParameters
     */
    public function withName(StringLiteral $name)
    {
        $c = clone $this;
        $c->name = $name;
        return $c;
    }

    /**
     * @return StringLiteral|null
     */
    public function getName()
    {
        return $this->name;
    }
}
