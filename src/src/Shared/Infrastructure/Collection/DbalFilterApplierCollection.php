<?php

namespace App\Shared\Infrastructure\Collection;

use App\Shared\Application\FilterAndSort\Collection\FilterCollection;
use App\Shared\Domain\TypedCollection;
use App\Shared\Infrastructure\Filter\DbalFilterApplierInterface;
use Doctrine\DBAL\Query\QueryBuilder;

/** @extends TypedCollection<DbalFilterApplierInterface> */
final class DbalFilterApplierCollection extends TypedCollection
{
    public function typeAllowed(): string
    {
        return DbalFilterApplierInterface::class;
    }

    public function applyAll(FilterCollection $filters, QueryBuilder $builder): void
    {
        foreach ($filters as $filter) {
            foreach ($this as $filterApplier) {
                if (!$filterApplier->supports($filter)) {
                    continue;
                }

                $filterApplier->apply($builder, $filter);
            }
        }
    }
}