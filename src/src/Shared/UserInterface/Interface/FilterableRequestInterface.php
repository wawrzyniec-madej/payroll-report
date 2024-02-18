<?php

declare(strict_types=1);

namespace App\Shared\UserInterface\Interface;

use App\Shared\Application\FilterAndSort\Collection\FilterCollection;
use App\Shared\Application\FilterAndSort\Collection\FilterNameCollection;

interface FilterableRequestInterface
{
    public function getAllowedFilterNames(): FilterNameCollection;

    public function getFilters(): FilterCollection;
}
