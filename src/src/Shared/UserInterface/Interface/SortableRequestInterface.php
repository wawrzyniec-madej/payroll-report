<?php

namespace App\Shared\UserInterface\Interface;

use App\Shared\Application\FilterAndSort\Collection\SortNameCollection;
use App\Shared\Application\FilterAndSort\Sort;

interface SortableRequestInterface
{
    public static function getAllowedSortNames(): SortNameCollection;

    public function getSort(): ?Sort;
}