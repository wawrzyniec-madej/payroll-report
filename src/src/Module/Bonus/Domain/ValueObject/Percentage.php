<?php

declare(strict_types=1);

namespace App\Module\Bonus\Domain\ValueObject;

use App\Module\Bonus\Domain\Exception\InvalidPercentageException;

final readonly class Percentage
{
    /** @throws InvalidPercentageException */
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
