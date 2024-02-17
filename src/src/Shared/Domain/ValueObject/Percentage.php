<?php

namespace App\Shared\Domain\ValueObject;

use App\Shared\Domain\Exception\InvalidPercentageException;

final readonly class Percentage
{
    public function __construct(
        private int $value
    ) {
        if ($this->value > 100 || $this->value <= 0) {
            throw InvalidPercentageException::create($this->value);
        }
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getFloat(): float
    {
        return $this->value / 100;
    }
}