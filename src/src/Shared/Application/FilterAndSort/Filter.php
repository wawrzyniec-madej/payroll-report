<?php

declare(strict_types=1);

namespace App\Shared\Application\FilterAndSort;

/** This class could be much cooler, having value resolvers and such */
final readonly class Filter
{
    public function __construct(
        private FilterName $name,
        private string $value
    ) {
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getName(): FilterName
    {
        return $this->name;
    }
}
