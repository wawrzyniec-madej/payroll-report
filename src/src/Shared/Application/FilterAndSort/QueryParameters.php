<?php

namespace App\Shared\Application\FilterAndSort;

final readonly class QueryParameters
{
    /** @param array<string, mixed> $value */
    public function __construct(
        private array $value
    ) {
    }
}