<?php

declare(strict_types=1);

namespace App\Shared\Domain\Exception;

use App\Shared\Domain\Enum\CurrencyEnum;

final class IncompatibleMoneyException extends DomainException
{
    public static function create(CurrencyEnum $provided, CurrencyEnum $expected): self
    {
        return new self(
            sprintf('Incompatible money currency [%s]. Expected: [%s].', $provided->value, $expected->value)
        );
    }
}
