<?php

namespace App\Shared\UserInterface\Factory;

use App\Shared\Application\FilterAndSort\Collection\FilterCollection;
use App\Shared\Application\FilterAndSort\Collection\FilterNameCollection;
use App\Shared\Application\FilterAndSort\Filter;
use App\Shared\Domain\Exception\CollectionElementInvalidException;

final class FilterFactory
{
    /**
     * @param array<string, string|array<string, string>> $providedParams
     *
     * @throws CollectionElementInvalidException
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
                    new Filter($filterName->getValue(), $value)
                );
            }
        }

        return $filters;
    }
}
