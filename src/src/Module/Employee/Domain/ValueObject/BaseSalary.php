<?php

namespace App\Module\Employee\Domain\ValueObject;

use App\Shared\Domain\ValueObject\Money;

final readonly class BaseSalary
{
    public function __construct(
        private Money $value
    ) {
    }

    public function getValue(): Money
    {
        return $this->value;
    }
}
