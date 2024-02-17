<?php

namespace App\Module\PayrollReport\Infrastructure\Search\PayrollReportRows\FilterApplier;

use App\Shared\Application\FilterAndSort\Filter;
use App\Shared\Infrastructure\Filter\DbalFilterApplierInterface;
use Doctrine\DBAL\Query\QueryBuilder;

final class SurnameFilterApplier implements DbalFilterApplierInterface
{
    public function apply(QueryBuilder $builder, Filter $filter): void
    {
        $builder
            ->andWhere('prr.surname = :surname')
            ->setParameter('surname', $filter->getValue());
    }

    public function supports(Filter $filter): bool
    {
        return $filter->getName() === 'surname';
    }
}