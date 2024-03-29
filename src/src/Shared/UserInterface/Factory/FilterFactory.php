<?php

declare(strict_types=1);

namespace App\Shared\UserInterface\Factory;

use App\Shared\Application\FilterAndSort\Collection\FilterCollection;
use App\Shared\Application\FilterAndSort\Collection\FilterNameCollection;
use App\Shared\Application\FilterAndSort\Filter;

final class FilterFactory
{
    /**
     * @param array<string, string|array<string, string>> $providedParams
     */
    public function create(FilterNameCollection $allowedFilterNames, array $providedParams): FilterCollection
    {
        $filters = FilterCollection::createEmpty();
        foreach ($allowedFilterNames as $filterName) {
            foreach ($providedParams as $key => $value) {
                if (
                    $key !== $filterName->getValue()
                    || !is_string($value)
                ) {
                    continue;
                }

                $filters->add(
                    new Filter($filterName, $value)
                );
            }
        }

        return $filters;
    }
}
