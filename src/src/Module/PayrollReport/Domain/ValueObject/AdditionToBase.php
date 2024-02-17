<?php

namespace App\Module\PayrollReport\Domain\ValueObject;

use App\Shared\Domain\ValueObject\Money;

final readonly class AdditionToBase
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
