<?php

declare(strict_types=1);

namespace App\Module\Department\Domain\ValueObject;

final readonly class Name
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
