<?php

namespace App\Module\PayrollReport\Domain\ValueObject;

final readonly class BonusName
{
    public function __construct(
        private string $value
    ) {
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
