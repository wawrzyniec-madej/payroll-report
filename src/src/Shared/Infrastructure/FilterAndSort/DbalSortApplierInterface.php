<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\FilterAndSort;

use App\Shared\Application\FilterAndSort\Sort;
use Doctrine\DBAL\Query\QueryBuilder;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(name: 'app.dbal_sort_applier')]
interface DbalSortApplierInterface
{
    public function apply(QueryBuilder $builder, Sort $sort): void;

    public function supports(object $finder, Sort $sort): bool;
}
