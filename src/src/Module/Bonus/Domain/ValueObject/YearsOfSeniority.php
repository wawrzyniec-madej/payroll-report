<?php

namespace App\Module\Bonus\Domain\ValueObject;

use App\Module\Bonus\Domain\Exception\InvalidYearsOfSeniorityException;

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

    public function isGreaterThan(self $compared): bool
    {
        return $this->value > $compared->value;
    }
}
