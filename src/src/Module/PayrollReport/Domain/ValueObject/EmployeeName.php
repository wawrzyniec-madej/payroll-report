<?php

namespace App\Module\PayrollReport\Domain\ValueObject;

final readonly class EmployeeName
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
