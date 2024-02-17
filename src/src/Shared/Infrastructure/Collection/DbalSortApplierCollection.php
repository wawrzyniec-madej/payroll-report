<?php

namespace App\Shared\Infrastructure\Collection;

use App\Shared\Application\FilterAndSort\Sort;
use App\Shared\Domain\TypedCollection;
use App\Shared\Infrastructure\Sort\DbalSortApplierInterface;
use Doctrine\DBAL\Query\QueryBuilder;

/** @extends TypedCollection<DbalSortApplierInterface> */
final class DbalSortApplierCollection extends TypedCollection
{
    public function typeAllowed(): string
    {
        return DbalSortApplierInterface::class;
    }

    public function applyAll(Sort $sort, QueryBuilder $builder): void
    {
        foreach ($this as $sortApplier) {
            if (!$sortApplier->supports($sort)) {
                continue;
            }

            $sortApplier->apply($builder, $sort);
        }
    }
}