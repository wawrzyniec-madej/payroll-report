<?php

namespace App\Shared\Domain\ValueObject;

final readonly class Identifier
{
    public function __construct(
        private string $value
    ) {
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqual(self $compared): bool
    {
        return $this->value === $compared->value;
    }
}
