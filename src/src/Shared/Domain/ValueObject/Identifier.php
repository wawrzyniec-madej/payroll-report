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
}
