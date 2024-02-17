<?php

namespace App\Shared\Domain\ValueObject;

final class Identifier
{
    public function __construct(
        private readonly string $value
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
