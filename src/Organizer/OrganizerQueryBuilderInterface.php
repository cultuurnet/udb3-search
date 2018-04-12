<?php

namespace CultuurNet\UDB3\Search\Organizer;

use CultuurNet\UDB3\Address\PostalCode;
use CultuurNet\UDB3\Search\QueryBuilderInterface;
use ValueObjects\StringLiteral\StringLiteral;
use ValueObjects\Web\Url;

interface OrganizerQueryBuilderInterface extends QueryBuilderInterface
{
    /**
     * @param StringLiteral $input
     * @return static
     */
    public function withAutoCompleteFilter(StringLiteral $input);

    /**
     * @param Url $url
     * @return static
     */
    public function withWebsiteFilter(Url $url);

    /**
     * @param PostalCode $postalCode
     * @return static
     */
    public function withPostalCodeFilter(PostalCode $postalCode);
}
