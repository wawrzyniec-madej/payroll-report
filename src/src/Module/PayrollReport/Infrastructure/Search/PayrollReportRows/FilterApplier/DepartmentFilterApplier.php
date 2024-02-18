<?php

namespace App\Module\PayrollReport\Infrastructure\Search\PayrollReportRows\FilterApplier;

use App\Shared\Application\FilterAndSort\Filter;
use App\Shared\Infrastructure\Filter\DbalFilterApplierInterface;
use Doctrine\DBAL\Query\QueryBuilder;

final class DepartmentFilterApplier implements DbalFilterApplierInterface
{
    public function apply(QueryBuilder $builder, Filter $filter): void
    {
        $builder
            ->andWhere('prr.department = :department')
            ->setParameter('department', $filter->getValue());
    }

    public function supports(Filter $filter): bool
    {
        return 'department' === $filter->getName();
    }
}
