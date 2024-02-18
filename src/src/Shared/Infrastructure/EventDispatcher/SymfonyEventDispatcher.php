<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\EventDispatcher;

use App\Shared\Domain\AggregateRoot;
use App\Shared\Domain\Exception\CollectionElementInvalidException;
use App\Shared\Domain\Interface\AggregateEventDispatcherInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

final readonly class SymfonyEventDispatcher implements AggregateEventDispatcherInterface
{
    public function __construct(
        private EventDispatcherInterface $eventDispatcher
    ) {
    }

    /** @throws CollectionElementInvalidException */
    public function dispatch(AggregateRoot $aggregateRoot): void
    {
        foreach ($aggregateRoot->pullEvents() as $event) {
            $this->eventDispatcher->dispatch($event);
        }
    }
}
