<?php

declare(strict_types=1);

namespace App\Shared\UserInterface\Factory;

use App\Shared\Application\FilterAndSort\Collection\SortNameCollection;
use App\Shared\Application\FilterAndSort\Enum\SortDirectionEnum;
use App\Shared\Application\FilterAndSort\Sort;
use App\Shared\Application\FilterAndSort\SortName;
use App\Shared\UserInterface\Exception\InvalidSortException;

final class SortFactory
{
    private const SORT_PARAM_NAME = 'sort';

    /**
     * @param array<string, string|array<string, string>> $providedParams
     *
     * @throws InvalidSortException
     */
    public function create(SortNameCollection $allowedSortNames, array $providedParams): ?Sort
    {
        if (!array_key_exists(self::SORT_PARAM_NAME, $providedParams)) {
            return null;
        }

        $parameter = $providedParams[self::SORT_PARAM_NAME];

        if (!is_array($parameter)) {
            return null;
        }

        if (1 !== count($parameter)) {
            return null;
        }

        $providedSortName = new SortName(array_keys($parameter)[0]);

        if (!$allowedSortNames->contains($providedSortName)) {
            return null;
        }

        $parameterValue = $parameter[$providedSortName->getValue()];

        $direction = SortDirectionEnum::tryFrom($parameterValue) ?? throw InvalidSortException::create($parameterValue, $providedSortName->getValue());

        return new Sort(
            $providedSortName,
            $direction
        );
    }
}
