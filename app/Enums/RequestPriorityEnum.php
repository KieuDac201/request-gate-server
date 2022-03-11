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
    const REQUEST_PRIORITY_LOW = 1;
    const REQUEST_PRIORITY_NORMAL = 2;
    const REQUEST_PRIORITY_HIGH = 3;
}
