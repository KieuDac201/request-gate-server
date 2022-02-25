<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class CategoryStatusEnum extends Enum
{
    const CATEGORY_DEACTIVE_STATUS = 0;
    const CATEGORY_ACTIVE_STATUS = 1;
}
