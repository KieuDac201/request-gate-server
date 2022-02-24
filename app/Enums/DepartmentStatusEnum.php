<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class DepartmentStatusEnum extends Enum
{
    const DEPARMENT_DEACTIVE_STATUS = 0;
    const DEPARMENT_ACTIVE_STATUS = 1;
}
