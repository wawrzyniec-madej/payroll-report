<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Collection;

use App\Shared\Application\FilterAndSort\Sort;
use App\Shared\Domain\TypedCollection;
use App\Shared\Infrastructure\FilterAndSort\DbalSortApplierInterface;
use Doctrine\DBAL\Query\QueryBuilder;

/** @extends TypedCollection<DbalSortApplierInterface> */
final class DbalSortApplierCollection extends TypedCollection
{
    public function typeAllowed(): string
    {
        return DbalSortApplierInterface::class;
    }
}
