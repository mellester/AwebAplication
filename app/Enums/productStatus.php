<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static notPublished()
 * @method static static Published()
 * @method static static paidPublished()
 */
final class productStatus extends Enum
{
    const notPublished = "notPublished";
    const Published =   "Published";
    const paidPublished = "paidPublished";
}
