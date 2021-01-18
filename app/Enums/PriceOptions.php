<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class PriceOptions extends Enum
{
    const MinPrice =   "MinPrice";
    const SuggestPrice =   "SuggestPrice";
    const BuyOutPrice = "BuyOutPrice";
}
