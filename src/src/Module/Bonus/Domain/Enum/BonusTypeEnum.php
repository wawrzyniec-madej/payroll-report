<?php

declare(strict_types=1);

namespace App\Module\Bonus\Domain\Enum;

enum BonusTypeEnum: string
{
    case PERCENTAGE = 'percentage';
    case SENIORITY = 'seniority';

    /** @return list<string> */
    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
