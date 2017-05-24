<?php

namespace CultuurNet\UDB3\Search\Offer;

use ValueObjects\Enum\Enum;

/**
 * @method static SortBy AVAILABLE_TO()
 * @method static SortBy SCORE()
 * @method static SortBy DISTANCE()
 */
class SortBy extends Enum
{
    const AVAILABLE_TO = 'availableTo';
    const SCORE = 'score';
    const DISTANCE = 'distance';
}
