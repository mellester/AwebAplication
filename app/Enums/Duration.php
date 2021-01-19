<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Hour()
 * @method static static Week()
 * @method static static Month()
 * @method static static Day()
 */
final class Duration extends Enum
{
    const Hour =   "Hour";
    const Week =   "Week";
    const Month =  "Month";
    const Day =  "Day";
}
