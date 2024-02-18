<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Collection;

use App\Shared\Infrastructure\FilterAndSort\DbalSortApplierInterface;
use App\Shared\TypedCollection;

/** @extends TypedCollection<DbalSortApplierInterface> */
final class DbalSortApplierCollection extends TypedCollection
{
    public function typeAllowed(): string
    {
        return DbalSortApplierInterface::class;
    }
}
