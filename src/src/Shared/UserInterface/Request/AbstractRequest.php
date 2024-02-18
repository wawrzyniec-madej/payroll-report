<?php

namespace App\Shared\UserInterface\Request;

use App\Shared\Application\FilterAndSort\Collection\FilterCollection;
use App\Shared\Application\FilterAndSort\Sort;
use App\Shared\UserInterface\Interface\RequestInterface;
use Symfony\Component\HttpFoundation\Request;

abstract readonly class AbstractRequest implements RequestInterface
{
    final private function __construct(
        protected Request $request,
        protected FilterCollection $filters,
        protected ?Sort $sort
    ) {
    }

    public static function create(Request $request, FilterCollection $filters, ?Sort $sort): static
    {
        return new static(
            $request,
            $filters,
            $sort
        );
    }
}
