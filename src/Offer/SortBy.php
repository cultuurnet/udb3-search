<?php

namespace CultuurNet\UDB3\Search\Offer;

use MabeEnum\Enum;

/**
 * @method static SortBy AVAILABLE_TO()
 * @method static SortBy SCORE()
 */
class SortBy extends Enum
{
    const AVAILABLE_TO = 'availableTo';
    const SCORE = 'score';
}
