<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class UserStatusEnum extends Enum
{
    const USER_DEACTIVE_STATUS = 0;
    const USER_ACTIVE_STATUS = 1;
}
