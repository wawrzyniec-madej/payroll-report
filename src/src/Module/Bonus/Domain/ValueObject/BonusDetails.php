<?php

declare(strict_types=1);

namespace App\Module\Bonus\Domain\ValueObject;

use App\Module\Bonus\Domain\Enum\BonusTypeEnum;
use App\Shared\Domain\Money;

final readonly class BonusDetails
{
    public function __construct(
        private BonusTypeEnum $type,
        private Money $bonus,
    ) {
    }

    public function getBonus(): Money
    {
        return $this->bonus;
    }

    public function getType(): BonusTypeEnum
    {
        return $this->type;
    }
}
