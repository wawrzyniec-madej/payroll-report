<?php

declare(strict_types=1);

namespace App\Shared\Application\FilterAndSort\Collection;

use App\Shared\Application\FilterAndSort\Filter;
use App\Shared\Components\TypedCollection;

/** @extends TypedCollection<Filter> */
final class FilterCollection extends TypedCollection
{
    public function typeAllowed(): string
    {
        return Filter::class;
    }
}
