<?php

declare(strict_types=1);

namespace App\Shared\Application\FilterAndSort\Collection;

use App\Shared\Application\FilterAndSort\SortName;
use App\Shared\Domain\TypedCollection;

/** @extends TypedCollection<SortName> */
final class SortNameCollection extends TypedCollection
{
    public function typeAllowed(): string
    {
        return SortName::class;
    }

    public function contains(SortName $sortName): bool
    {
        foreach ($this as $element) {
            if ($element->isEqual($sortName)) {
                return true;
            }
        }

        return false;
    }
}
