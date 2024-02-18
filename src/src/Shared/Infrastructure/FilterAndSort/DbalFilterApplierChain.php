<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\FilterAndSort;

use App\Shared\Application\FilterAndSort\Collection\FilterCollection;
use App\Shared\Domain\Exception\CollectionElementInvalidException;
use App\Shared\Infrastructure\Collection\DbalFilterApplierCollection;
use Doctrine\DBAL\Query\QueryBuilder;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

final class DbalFilterApplierChain
{
    private DbalFilterApplierCollection $filterAppliers;

    /**
     * @param iterable<DbalFilterApplierInterface> $dbalFilterAppliers
     *
     * @throws CollectionElementInvalidException
     */
    public function __construct(
        #[TaggedIterator(tag: 'app.dbal_filter_applier')]
        iterable $dbalFilterAppliers
    ) {
        $this->filterAppliers = DbalFilterApplierCollection::createFromSpread(...$dbalFilterAppliers);
    }

    public function applySupported(
        object $finder,
        FilterCollection $filters,
        QueryBuilder $builder
    ): void {
        foreach ($filters as $filter) {
            foreach ($this->filterAppliers as $filterApplier) {
                if (!$filterApplier->supports($finder, $filter)) {
                    continue;
                }

                $filterApplier->apply($builder, $filter);
            }
        }
    }
}
