<?php

namespace CultuurNet\UDB3\Search\Offer;

use ValueObjects\Enum\Enum;

/**
 * @method static MetaDataDateType CREATED()
 * @method static MetaDataDateType MODIFIED()
 */
class MetaDataDateType extends enum
{
    const CREATED = 'created';
    const MODIFIED = 'modified';
}
