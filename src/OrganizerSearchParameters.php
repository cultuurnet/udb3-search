<?php

namespace CultuurNet\UDB3\Search;

use ValueObjects\String\String as StringLiteral;
use ValueObjects\Web\Url;

class OrganizerSearchParameters extends AbstractSearchParameters
{
    /**
     * @var StringLiteral|null
     */
    private $name;

    /**
     * @var Url|null
     */
    private $website;

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

    /**
     * @param Url $website
     * @return OrganizerSearchParameters
     */
    public function withWebsite(Url $website)
    {
        $c = clone $this;
        $c->website = $website;
        return $c;
    }

    /**
     * @return Url|null
     */
    public function getWebsite()
    {
        return $this->website;
    }
}
