<?php

namespace App\Module\Employee\Domain\ValueObject;

final readonly class Surname
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
