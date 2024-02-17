<?php

namespace App\Module\PayrollReport\Domain\ValueObject;

use App\Shared\Domain\ValueObject\Money;

final class AdditionToBase
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
