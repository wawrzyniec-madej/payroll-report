<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Collection;

use App\Shared\Infrastructure\FilterAndSort\DbalFilterApplierInterface;
use App\Shared\TypedCollection;

/** @extends TypedCollection<DbalFilterApplierInterface> */
final class DbalFilterApplierCollection extends TypedCollection
{
    public function typeAllowed(): string
    {
        return DbalFilterApplierInterface::class;
    }
}
