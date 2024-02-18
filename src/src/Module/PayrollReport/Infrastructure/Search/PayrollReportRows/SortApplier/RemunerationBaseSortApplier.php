<?php

namespace App\Module\PayrollReport\Infrastructure\Search\PayrollReportRows\SortApplier;

use App\Shared\Application\FilterAndSort\Sort;
use App\Shared\Infrastructure\Sort\DbalSortApplierInterface;
use Doctrine\DBAL\Query\QueryBuilder;

final class RemunerationBaseSortApplier implements DbalSortApplierInterface
{
    public function apply(QueryBuilder $builder, Sort $sort): void
    {
        $builder->orderBy('prr.remuneration_base_amount', $sort->getDirection()->value);
    }

    public function supports(Sort $sort): bool
    {
        return 'remunerationBase' === $sort->getName()->getValue();
    }
}
