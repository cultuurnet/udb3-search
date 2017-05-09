<?php

namespace CultuurNet\UDB3\Search;

use MabeEnum\Enum;

/**
 * @method static SortOrder ASC()
 * @method static SortOrder DESC()
 */
class SortOrder extends Enum
{
    const ASC = 'asc';
    const DESC = 'desc';
}
