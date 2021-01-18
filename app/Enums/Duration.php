<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class Duration extends Enum
{
    const Hour =   "Hour";
    const Week =   "Week";
    const Month =  "Month";
}
