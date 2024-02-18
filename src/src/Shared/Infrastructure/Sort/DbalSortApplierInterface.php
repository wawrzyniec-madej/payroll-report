<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Sort;

use App\Shared\Application\FilterAndSort\Sort;
use Doctrine\DBAL\Query\QueryBuilder;

interface DbalSortApplierInterface
{
    public function apply(QueryBuilder $builder, Sort $sort): void;

    public function supports(Sort $sort): bool;
}
