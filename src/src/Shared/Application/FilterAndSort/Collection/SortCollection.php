<?php

declare(strict_types=1);

namespace App\Shared\Application\FilterAndSort\Collection;

use App\Shared\Application\FilterAndSort\Sort;
use App\Shared\Components\TypedCollection;

/** @extends TypedCollection<Sort> */
final class SortCollection extends TypedCollection
{
    public function typeAllowed(): string
    {
        return Sort::class;
    }
}
