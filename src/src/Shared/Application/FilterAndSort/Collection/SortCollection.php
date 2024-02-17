<?php

namespace App\Shared\Application\FilterAndSort\Collection;

use App\Shared\Application\FilterAndSort\Sort;
use App\Shared\Domain\TypedCollection;

/** @extends TypedCollection<Sort> */
final class SortCollection extends TypedCollection
{
    public function typeAllowed(): string
    {
        return Sort::class;
    }
}