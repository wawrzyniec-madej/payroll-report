<?php

namespace App\Shared\Infrastructure\Filter;

use App\Shared\Application\FilterAndSort\Filter;
use Doctrine\DBAL\Query\QueryBuilder;

interface DbalFilterApplierInterface
{
    public function apply(QueryBuilder $builder, Filter $filter): void;

    public function supports(Filter $filter): bool;
}
