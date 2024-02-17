<?php

namespace App\Shared\Application\FilterAndSort\Collection;

use App\Shared\Application\FilterAndSort\FilterName;
use App\Shared\Domain\TypedCollection;

/** @extends TypedCollection<FilterName> */
final class FilterNameCollection extends TypedCollection
{
    public function typeAllowed(): string
    {
        return FilterName::class;
    }
}