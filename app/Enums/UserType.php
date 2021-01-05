<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Administrator()
 * @method static static Moderator()
 * @method static static Subscriber()
 * @method static static User()
 */
final class UserType extends Enum
{
    const Administrator = 0;
    const Moderator = 1;
    const Subscriber = 2;
    const User = 3;
}
