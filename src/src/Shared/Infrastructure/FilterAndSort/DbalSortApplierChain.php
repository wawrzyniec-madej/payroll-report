<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\FilterAndSort;

use App\Shared\Application\FilterAndSort\Sort;
use App\Shared\Domain\Exception\CollectionElementInvalidException;
use App\Shared\Infrastructure\Collection\DbalSortApplierCollection;
use Doctrine\DBAL\Query\QueryBuilder;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

final class DbalSortApplierChain
{
    private DbalSortApplierCollection $sortAppliers;

    /**
     * @param iterable<DbalFilterApplierInterface> $dbalSortAppliers
     *
     * @throws CollectionElementInvalidException
     */
    public function __construct(
        #[TaggedIterator(tag: 'app.dbal_sort_applier')]
        iterable $dbalSortAppliers
    ) {
        $this->sortAppliers = DbalSortApplierCollection::createFromSpread(...$dbalSortAppliers);
    }

    public function applySupported(object $finder, ?Sort $sort, QueryBuilder $builder): void
    {
        if (!$sort) {
            return;
        }

        foreach ($this->sortAppliers as $sortApplier) {
            if (!$sortApplier->supports($finder, $sort)) {
                continue;
            }

            $sortApplier->apply($builder, $sort);
        }
    }
}
