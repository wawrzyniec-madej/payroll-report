<?php

namespace App\Module\Employee\Domain\ValueObject;

final class Surname
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