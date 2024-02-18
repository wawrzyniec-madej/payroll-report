<?php

declare(strict_types=1);

namespace App\Shared\UserInterface\ValueResolver;

use App\Shared\UserInterface\Factory\FilterFactory;
use App\Shared\UserInterface\Factory\SortFactory;
use App\Shared\UserInterface\Interface\RequestInterface;
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

    /**
     * @return iterable<RequestInterface>
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $argumentType = $argument->getType();

        if (
            !$argumentType
            || !is_subclass_of($argumentType, RequestInterface::class)
            || self::ALLOWED_NAME !== $argument->getName()
        ) {
            return [];
        }

        return [
            $argumentType::create(
                $request,
                $this->filterFactory,
                $this->sortFactory
            ),
        ];
    }
}
