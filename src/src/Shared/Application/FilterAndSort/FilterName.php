<?php

namespace App\Shared\Application\FilterAndSort;

final readonly class FilterName
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