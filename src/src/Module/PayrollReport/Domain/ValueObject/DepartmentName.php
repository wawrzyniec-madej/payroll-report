<?php

namespace App\Module\PayrollReport\Domain\ValueObject;

final class DepartmentName
{
    public function __construct(
        private readonly string $value
    ) {
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
