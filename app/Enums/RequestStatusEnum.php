<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class RequestStatusEnum extends Enum
{
    const REQUEST_STATUS_OPEN = 1;
    const REQUEST_STATUS_IN_PROGRESS = 2;
    const REQUEST_STATUS_CLOSE = 3;
}
