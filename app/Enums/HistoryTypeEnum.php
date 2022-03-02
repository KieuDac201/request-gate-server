<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class HistoryTypeEnum extends Enum
{
    const HISTORY_TYPE_CREATE = 'create';
    const HISTORY_TYPE_COMMENT = 'comment';
    const HISTORY_TYPE_UPDATE = 'update';
}
