<?php

declare(strict_types=1);

namespace App\Shared\Application\FilterAndSort;

use App\Shared\Application\FilterAndSort\Enum\SortDirectionEnum;

final readonly class Sort
{
    public function __construct(
        private SortName $name,
        private SortDirectionEnum $direction
    ) {
    }

    public function getName(): SortName
    {
        return $this->name;
    }

    public function getDirection(): SortDirectionEnum
    {
        return $this->direction;
    }
}
