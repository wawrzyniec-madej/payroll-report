<?php

declare(strict_types=1);

namespace App\Shared\Domain\Enum;

enum CurrencyEnum: string
{
    case USD = 'usd';
    case PLN = 'pln';

    public function isEqual(self $compared): bool
    {
        return $this->value === $compared->value;
    }
}
