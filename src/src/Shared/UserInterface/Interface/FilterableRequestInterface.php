<?php

declare(strict_types=1);

namespace App\Shared\UserInterface\Interface;

use App\Shared\Application\FilterAndSort\Collection\FilterCollection;
use App\Shared\Application\FilterAndSort\Collection\FilterNameCollection;
use App\Shared\Domain\Exception\CollectionElementInvalidException;

interface FilterableRequestInterface
{
    /** @throws CollectionElementInvalidException */
    public function getAllowedFilterNames(): FilterNameCollection;

    public function getFilters(): FilterCollection;
}
