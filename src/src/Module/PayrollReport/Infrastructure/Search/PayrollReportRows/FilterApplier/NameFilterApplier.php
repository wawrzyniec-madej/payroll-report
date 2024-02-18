<?php

declare(strict_types=1);

namespace App\Module\PayrollReport\Infrastructure\Search\PayrollReportRows\FilterApplier;

use App\Shared\Application\FilterAndSort\Filter;
use App\Shared\Infrastructure\Filter\DbalFilterApplierInterface;
use Doctrine\DBAL\Query\QueryBuilder;

final class NameFilterApplier implements DbalFilterApplierInterface
{
    public function apply(QueryBuilder $builder, Filter $filter): void
    {
        $builder
            ->andWhere('prr.name = :name')
            ->setParameter('name', $filter->getValue());
    }

    public function supports(Filter $filter): bool
    {
        return 'name' === $filter->getName();
    }
}
