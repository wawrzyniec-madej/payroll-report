<?php

namespace App\Shared\UserInterface\Interface;

use App\Shared\Application\FilterAndSort\Collection\SortNameCollection;
use App\Shared\Application\FilterAndSort\Sort;
use App\Shared\Domain\Exception\CollectionElementInvalidException;

interface SortableRequestInterface
{
    /** @throws CollectionElementInvalidException */
    public static function getAllowedSortNames(): SortNameCollection;

    public function getSort(): ?Sort;
}
