<?php

declare(strict_types=1);

namespace App\Module\PayrollReport\Infrastructure\Search\PayrollReportRows\SortApplier;

use App\Module\PayrollReport\Infrastructure\Search\PayrollReportRows\DbalSearchPayrollReportRow;
use App\Shared\Application\FilterAndSort\Sort;
use App\Shared\Infrastructure\FilterAndSort\DbalSortApplierInterface;
use Doctrine\DBAL\Query\QueryBuilder;

final class NameSortApplier implements DbalSortApplierInterface
{
    public function apply(QueryBuilder $builder, Sort $sort): void
    {
        $builder->orderBy('prr.name', $sort->getDirection()->value);
    }

    public function supports(object $finder, Sort $sort): bool
    {
        return
            'name' === $sort->getName()->getValue()
            && $finder instanceof DbalSearchPayrollReportRow;
    }
}
