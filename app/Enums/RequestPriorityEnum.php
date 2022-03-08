<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class RequestPriorityEnum extends Enum
{
    const REQUEST_PRIORITY_NORMAL = 0;
    const REQUEST_PRIORITY_HIGH = 1;
}
