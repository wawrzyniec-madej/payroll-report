<?php

namespace App\Module\PayrollReport\Infrastructure\Search\PayrollReportRows\SortApplier;

use App\Shared\Application\FilterAndSort\Sort;
use App\Shared\Infrastructure\Sort\DbalSortApplierInterface;
use Doctrine\DBAL\Query\QueryBuilder;

final class AdditionToBaseSortApplier implements DbalSortApplierInterface
{
    public function apply(QueryBuilder $builder, Sort $sort): void
    {
        $builder->orderBy('prr.addition_to_base_amount', $sort->getDirection()->value);
    }

    public function supports(Sort $sort): bool
    {
        return $sort->getName()->getValue() === 'additionToBase';
    }
}