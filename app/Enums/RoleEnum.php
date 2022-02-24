<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class RoleEnum extends Enum
{
    const ROLE_ADMIN = 1;
    const ROLE_QUAN_LY_BO_PHAN = 2;
    const ROLE_CAN_BO_NHAN_VIEN = 3;
}
