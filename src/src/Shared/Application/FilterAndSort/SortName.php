<?php

namespace App\Shared\Application\FilterAndSort;

final readonly class SortName
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