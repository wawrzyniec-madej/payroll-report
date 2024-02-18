<?php

declare(strict_types=1);

namespace App\Shared\Application\FilterAndSort\Collection;

use App\Shared\Application\FilterAndSort\FilterName;
use App\Shared\Components\TypedCollection;

/** @extends TypedCollection<FilterName> */
final class FilterNameCollection extends TypedCollection
{
    public function typeAllowed(): string
    {
        return FilterName::class;
    }
}
