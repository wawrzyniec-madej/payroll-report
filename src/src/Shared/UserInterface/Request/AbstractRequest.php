<?php

declare(strict_types=1);

namespace App\Shared\UserInterface\Request;

use App\Shared\Application\FilterAndSort\Collection\FilterCollection;
use App\Shared\Application\FilterAndSort\Sort;
use App\Shared\Domain\Exception\CollectionElementInvalidException;
use App\Shared\UserInterface\Exception\InvalidSortException;
use App\Shared\UserInterface\Factory\FilterFactory;
use App\Shared\UserInterface\Factory\SortFactory;
use App\Shared\UserInterface\Interface\FilterableRequestInterface;
use App\Shared\UserInterface\Interface\RequestInterface;
use App\Shared\UserInterface\Interface\SortableRequestInterface;
use Symfony\Component\HttpFoundation\Request;

abstract readonly class AbstractRequest implements RequestInterface, FilterableRequestInterface, SortableRequestInterface
{
    final private function __construct(
        protected Request $request,
        protected FilterFactory $filterFactory,
        protected SortFactory $sortFactory
    ) {
    }

    public static function create(Request $request, FilterFactory $filterFactory, SortFactory $sortFactory): static
    {
        return new static(
            $request,
            $filterFactory,
            $sortFactory
        );
    }

    /** @throws CollectionElementInvalidException */
    public function getFilters(): FilterCollection
    {
        return $this->filterFactory->create(
            $this->getAllowedFilterNames(),
            $this->request->query->all()
        );
    }

    /**
     * @throws CollectionElementInvalidException
     * @throws InvalidSortException
     */
    public function getSort(): ?Sort
    {
        return $this->sortFactory->create(
            $this->getAllowedSortNames(),
            $this->request->query->all()
        );
    }
}
