<?php

namespace App\Shared\UserInterface\Interface;

use App\Shared\Application\FilterAndSort\Collection\FilterCollection;
use App\Shared\Application\FilterAndSort\Collection\FilterNameCollection;

interface FilterableRequestInterface
{
    public static function getAllowedFilterNames(): FilterNameCollection;

    public function getFilters(): FilterCollection;
}