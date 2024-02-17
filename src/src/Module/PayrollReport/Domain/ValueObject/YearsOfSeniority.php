<?php

namespace App\Module\PayrollReport\Domain\ValueObject;

use App\Module\PayrollReport\Domain\Exception\InvalidYearsOfSeniorityException;

final readonly class YearsOfSeniority
{
    public function __construct(
        private int $value
    ) {
        if ($this->value < 0) {
            throw InvalidYearsOfSeniorityException::create($this->value);
        }
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
