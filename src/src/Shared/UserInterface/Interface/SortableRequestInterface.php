<?php

declare(strict_types=1);

namespace App\Shared\UserInterface\Interface;

use App\Shared\Application\FilterAndSort\Collection\SortNameCollection;
use App\Shared\Application\FilterAndSort\Sort;

interface SortableRequestInterface
{
    public function getAllowedSortNames(): SortNameCollection;

    public function getSort(): ?Sort;
}
