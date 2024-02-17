<?php

namespace App\Shared\UserInterface\Factory;

use App\Shared\Application\FilterAndSort\Collection\FilterCollection;
use App\Shared\Application\FilterAndSort\Collection\FilterNameCollection;
use App\Shared\Application\FilterAndSort\Filter;

final class FilterFactory
{
    /** @param array<string, mixed> $providedParams */
    public function create(FilterNameCollection $allowedFilterNames, array $providedParams): FilterCollection
    {
        $filters = FilterCollection::createEmpty();
        foreach ($allowedFilterNames as $filterName) {
            foreach ($providedParams as $key => $value) {
                if ($key === $filterName->getValue()) {
                    $filters->add(
                        new Filter($filterName->getValue(), $value)
                    );
                }
            }
        }

        return $filters;
    }
}