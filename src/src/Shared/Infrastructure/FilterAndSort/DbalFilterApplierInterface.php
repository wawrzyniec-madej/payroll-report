<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\FilterAndSort;

use App\Shared\Application\FilterAndSort\Filter;
use Doctrine\DBAL\Query\QueryBuilder;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(name: 'app.dbal_filter_applier')]
interface DbalFilterApplierInterface
{
    public function apply(QueryBuilder $builder, Filter $filter): void;

    public function supports(object $finder, Filter $filter): bool;
}
