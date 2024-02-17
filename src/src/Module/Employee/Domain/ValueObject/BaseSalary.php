<?php

namespace App\Module\Employee\Domain\ValueObject;

use App\Shared\Domain\ValueObject\Money;

final class BaseSalary
{
    public function __construct(
        private readonly Money $value
    ) {
    }

    public function getValue(): Money
    {
        return $this->value;
    }
}