<?php

declare(strict_types=1);

namespace App\Module\PayrollReport\Infrastructure\Search\PayrollReportRows\FilterApplier;

use App\Module\PayrollReport\Infrastructure\Search\PayrollReportRows\DbalSearchPayrollReportRow;
use App\Shared\Application\FilterAndSort\Filter;
use App\Shared\Infrastructure\FilterAndSort\DbalFilterApplierInterface;
use Doctrine\DBAL\Query\QueryBuilder;

final class SurnameFilterApplier implements DbalFilterApplierInterface
{
    public function apply(QueryBuilder $builder, Filter $filter): void
    {
        $builder
            ->andWhere('prr.surname = :surname')
            ->setParameter('surname', $filter->getValue());
    }

    public function supports(object $finder, Filter $filter): bool
    {
        return
            'surname' === $filter->getName()
            && $finder instanceof DbalSearchPayrollReportRow;
    }
}
