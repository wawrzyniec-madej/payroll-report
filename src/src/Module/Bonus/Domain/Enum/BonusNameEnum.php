<?php

namespace App\Module\Bonus\Domain\Enum;

enum BonusNameEnum: string
{
    case PERCENTAGE = 'percentage';
    case SENIORITY = 'seniority';
}
