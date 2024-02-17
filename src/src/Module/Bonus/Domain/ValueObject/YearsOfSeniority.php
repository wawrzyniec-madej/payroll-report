<?php

namespace App\Module\Bonus\Domain\ValueObject;

final class YearsOfSeniority
{
    public function __construct(
        private readonly int $value
    ) {
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