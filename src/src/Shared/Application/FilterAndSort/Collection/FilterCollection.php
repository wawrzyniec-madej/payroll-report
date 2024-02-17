<?php

namespace App\Shared\Application\FilterAndSort\Collection;

use App\Shared\Application\FilterAndSort\Filter;
use App\Shared\Domain\TypedCollection;

/** @extends TypedCollection<Filter> */
final class FilterCollection extends TypedCollection
{
    public function typeAllowed(): string
    {
        return Filter::class;
    }
}