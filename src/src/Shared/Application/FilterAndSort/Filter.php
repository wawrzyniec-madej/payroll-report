<?php

namespace App\Shared\Application\FilterAndSort;

/** This class could be much cooler, having value resolvers and such */
final readonly class Filter
{
    public function __construct(
        private string $name,
        private string $value
    ) {
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getName(): string
    {
        return $this->name;
    }
}