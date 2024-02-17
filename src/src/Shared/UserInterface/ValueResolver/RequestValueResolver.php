<?php

namespace App\Shared\UserInterface\ValueResolver;

use App\Shared\Application\FilterAndSort\Collection\FilterCollection;
use App\Shared\UserInterface\Factory\FilterFactory;
use App\Shared\UserInterface\Factory\SortFactory;
use App\Shared\UserInterface\Interface\FilterableRequestInterface;
use App\Shared\UserInterface\Interface\RequestInterface;
use App\Shared\UserInterface\Interface\SortableRequestInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final class RequestValueResolver implements ValueResolverInterface
{
    private const ALLOWED_NAME = 'request';

    public function __construct(
        private readonly FilterFactory $filterFactory,
        private readonly SortFactory $sortFactory
    ) {
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $argumentType = $argument->getType();

        if (
            !is_subclass_of($argumentType, RequestInterface::class)
            || $argument->getName() !== self::ALLOWED_NAME
        ) {
            return [];
        }

        $filters = is_subclass_of($argumentType, FilterableRequestInterface::class)
            ? $this->filterFactory->create($argumentType::getAllowedFilterNames(), $request->query->all())
            : FilterCollection::createEmpty();

        $sort = is_subclass_of($argumentType, SortableRequestInterface::class)
            ? $this->sortFactory->create($argumentType::getAllowedSortNames(), $request->query->all())
            : FilterCollection::createEmpty();

        return [
            $argumentType::create(
                $request,
                $filters,
                $sort
            )
        ];
    }
}